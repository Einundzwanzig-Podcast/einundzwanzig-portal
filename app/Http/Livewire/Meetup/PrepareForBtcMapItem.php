<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;

class PrepareForBtcMapItem extends Component
{
    use Actions;

    public Meetup $meetup;

    public $model;

    public string $search = '';

    public $population;
    public $population_date = '';

    public ?int $osm_id = null;

    public array $osmSearchResults = [];

    public $selectedItemOSMPolygons;

    public $selectedItemOSMBoundaries;

    public $selectedItemPolygonsOSMfr;

    public $polygonsOSMfrX = 0.020000;

    public $polygonsOSMfrY = 0.005000;

    public $polygonsOSMfrZ = 0.005000;

    public $currentPercentage = 100;

    public bool $OSMBoundaries = false;

    public bool $polygonsOSMfr = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'osm_id' => ['except' => null],
    ];

    public function rules(): array
    {
        return [
            'search'            => 'required|string',
            'currentPercentage' => 'required|numeric',

            'model.simplified_geojson' => 'nullable',

            'OSMBoundaries' => 'bool',
            'polygonsOSMfr' => 'bool',

            'population'      => 'nullable|numeric',
            'population_date' => 'nullable|string',

            'polygonsOSMfrX' => 'numeric|max:1',
            'polygonsOSMfrY' => 'numeric|max:1',
            'polygonsOSMfrZ' => 'numeric|max:1',
        ];
    }

    public function mount(): void
    {
        $this->model = $this->meetup->city;
        $this->population = $this->model->population;
        $this->population_date = $this->model->population_date ?? '2021-12-31';
        $this->getSearchResults();
        if ($this->osm_id) {
            $this->selectedItemOSMPolygons = collect($this->osmSearchResults)
                ->firstWhere('osm_id', $this->osm_id);
            $this->executeMapshaper($this->currentPercentage);
        }
    }

    private function getSearchResults(): void
    {
        $responses = Http::pool(fn(Pool $pool) => [
            $pool->acceptJson()
                 ->get(
                     sprintf('https://nominatim.openstreetmap.org/search?q=%s&format=json&polygon_geojson=1&polygon_threshold=0.0003&email='.config('services.nominatim.email'),
                         $this->search)
                 ),
        ]);

        $this->osmSearchResults = collect($responses[0]->json())
            ->filter(fn($item
            ) => (
                     $item['geojson']['type'] === 'Polygon'
                     || $item['geojson']['type'] === 'MultiPolygon'
                 )
                 && $item['osm_id']
                 && count($item['geojson']['coordinates'], COUNT_RECURSIVE) < 100000
            )
            ->values()
            ->toArray();
    }

    private function executeMapshaper($percentage = 100): void
    {
        try {
            // put OSM geojson to storage
            Storage::disk('geo')
                   ->put('geojson_'.$this->selectedItemOSMPolygons['osm_id'].'.json',
                       json_encode($this->selectedItemOSMPolygons['geojson'], JSON_THROW_ON_ERROR)
                   );

            // execute mapshaper
            $input = storage_path('app/geo/geojson_'.$this->selectedItemOSMPolygons['osm_id'].'.json');
            $output = storage_path('app/geo/output_'.$this->selectedItemOSMPolygons['osm_id'].'.json');
            $mapShaperBinary = base_path('node_modules/mapshaper/bin/mapshaper');
            exec($mapShaperBinary.' '.$input.' -simplify dp '.$percentage.'% -o '.$output);
            $this->currentPercentage = $percentage;

            $mapShaperOutput = str(
                Storage::disk('geo')
                       ->get('output_'.$this->selectedItemOSMPolygons['osm_id'].'.json')
            );
            if ($mapShaperOutput->contains(['Polygon', 'MultiPolygon'])) {
                // trim geojson
                Storage::disk('geo')
                       ->put(
                           'trimmed_'.$this->selectedItemOSMPolygons['osm_id'].'.json',
                           $mapShaperOutput
                               ->after('{"type":"GeometryCollection", "geometries": [')
                               ->beforeLast(']}')
                               ->toString()
                       );
            } else {
                $this->notification()
                     ->warning('Warning',
                         sprintf('Geojson is not valid. After simplification, it contains no polygons. Instead it contains: %s',
                             $mapShaperOutput->after('{"type":')
                                             ->before(',')));

                return;
            }

            // put trimmed geojson to model
            $this->model->simplified_geojson = json_decode(
                trim(
                    Storage::disk('geo')
                           ->get('trimmed_'.$this->selectedItemOSMPolygons['osm_id'].'.json')
                ),
                false, 512, JSON_THROW_ON_ERROR
            );

            // emit event for AlpineJS
            $this->emit('geoJsonUpdated');

        } catch (\Exception $e) {
            $this->notification()
                 ->error('Error', $e->getMessage());
        }
    }

    public function saveSimplifiedGeoJson()
    {
        $this->model->osm_relation = $this->osm_id;
        $this->model->save();

        $this->notification()
             ->success('Success', 'Simplified GeoJSON saved.');
    }

    public function submitPolygonsOSM()
    {
        $this->validate();
        $postGenerate = Http::acceptJson()
                            ->asForm()
                            ->post(
                                'https://polygons.openstreetmap.fr/?id='.$this->selectedItemOSMPolygons['osm_id'],
                                [
                                    'x'        => $this->polygonsOSMfrX,
                                    'y'        => $this->polygonsOSMfrY,
                                    'z'        => $this->polygonsOSMfrZ,
                                    'generate' => 'Submit+Query',
                                ]
                            );
        if ($postGenerate->ok()) {
            $getUrl = sprintf(
                'https://polygons.openstreetmap.fr/get_geojson.py?id=%s&params=%s-%s-%s',
                $this->selectedItemOSMPolygons['osm_id'],
                (float) str($this->polygonsOSMfrX)
                    ->before('.')
                    ->toString().'.'.str($this->polygonsOSMfrX)
                    ->after('.')
                    ->padRight(6, '0')
                    ->toString(),
                (float) str($this->polygonsOSMfrY)
                    ->before('.')
                    ->toString().'.'.str($this->polygonsOSMfrY)
                    ->after('.')
                    ->padRight(6, '0')
                    ->toString(),
                (float) str($this->polygonsOSMfrZ)
                    ->before('.')
                    ->toString().'.'.str($this->polygonsOSMfrZ)
                    ->after('.')
                    ->padRight(6, '0')
                    ->toString(),
            );
            $response = Http::acceptJson()
                            ->get($getUrl);
            if ($response->json()) {
                $this->selectedItemPolygonsOSMfr = $response->json();
                $this->emit('geoJsonUpdated');
            } else {
                $this->notification()
                     ->warning('No data', 'No data found for this area.');
            }
        } else {
            $this->notification()
                 ->error('Error', 'Something went wrong: '.$postGenerate->status());
        }
    }

    public function submit(): void
    {
        $this->validate();
        $this->getSearchResults();
    }

    public function selectItem($index): void
    {
        $this->OSMBoundaries = false;
        $this->selectedItemOSMBoundaries = null;
        $this->selectedItemOSMPolygons = $this->osmSearchResults[$index];
        $this->osm_id = $this->selectedItemOSMPolygons['osm_id'];
        $this->model->osm_relation = $this->selectedItemOSMPolygons;

        $this->executeMapshaper(100);
    }

    public function updatedOSMBoundaries($value)
    {
        if ($value) {
            $response = Http::acceptJson()
                            ->asForm()
                            ->post('https://osm-boundaries.com/Ajax/GetBoundary', [
                                'db'          => 'osm20221205',
                                'waterOrLand' => 'water',
                                'osmId'       => '-'.$this->selectedItemOSMPolygons['osm_id'],
                            ]);
            if ($response->json()) {
                if (count($response->json()['coordinates'], COUNT_RECURSIVE) > 100000) {
                    $this->notification()
                         ->warning('Warning', 'Water boundaries are too big');

                    return;
                }

                $this->selectedItemOSMBoundaries = $response->json();
                $this->emit('geoJsonUpdated');
            } else {
                $this->notification()
                     ->warning('Warning', 'No water boundaries found');
            }
        } else {
            $this->selectedItemOSMBoundaries = null;
            $this->emit('geoJsonUpdated');
        }
    }

    public function updatedCurrentPercentage($value)
    {
        $this->executeMapshaper((float) $value);
    }

    public function setPercentage($percent): void
    {
        $this->executeMapshaper($percent);
    }

    public function updatedPopulation($value)
    {
        $this->model->population = str($value)
            ->replace(['.', ','], '')
            ->toInteger();
        $this->model->save();

        $this->notification()
             ->success('Success', 'Population saved.');
    }

    public function updatedPopulationDate($value)
    {
        $this->model->population_date = $value;
        $this->model->save();

        $this->notification()
             ->success('Success', 'Population saved.');
    }

    public function render()
    {
        return view('livewire.meetup.prepare-for-btc-map-item', [
            'percentages' => collect([
                0.5,
                0.75,
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8,
                9,
                10,
                15,
                20,
                25,
                30,
                40,
                50,
                60,
                75,
                80,
                100,
            ])
                ->reverse()
                ->values()
                ->toArray(),
        ]);
    }
}
