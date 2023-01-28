<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;

class PrepareForBtcMapItem extends Component
{
    use Actions;

    public Meetup $meetup;

    public $population;
    public $population_date;
    public $osmSearchResults;
    public $osmSearchResultsState;
    public $osmSearchResultsCountry;

    public $selectedItem;

    public function rules()
    {
        return [
            'population'      => 'required|numeric',
            'population_date' => 'required|string',
        ];
    }

    public function mount()
    {
        $response = Http::acceptJson()
                        ->get(
                            'https://nominatim.openstreetmap.org/search?city='.$this->meetup->city->name.'&format=json&polygon_geojson=1'
                        );
        $this->osmSearchResults = $response->json();

        $response = Http::acceptJson()
                        ->get(
                            'https://nominatim.openstreetmap.org/search?state='.$this->meetup->city->name.'&format=json&polygon_geojson=1'
                        );
        $this->osmSearchResultsState = $response->json();

        $response = Http::acceptJson()
                        ->get(
                            'https://nominatim.openstreetmap.org/search?country='.$this->meetup->city->name.'&format=json&polygon_geojson=1'
                        );
        $this->osmSearchResultsCountry = $response->json();

        if ($this->meetup->city->osm_relation) {
            $this->selectedItem = $this->meetup->city->osm_relation;
        }
    }

    public function updatedPopulation($value)
    {
        $this->meetup->city->population = $value;
        $this->meetup->city->save();
        $this->notification()->success('Population updated', 'Success');
    }

    public function updatedPopulationDate($value)
    {
        $this->meetup->city->population_date = $value;
        $this->meetup->city->save();
        $this->notification()->success('Population date updated', 'Success');
    }

    public function selectItem($index, bool $isState = false, $isCountry = false)
    {
        if ($isState) {
            $this->selectedItem = $this->osmSearchResultsState[$index];
        } elseif ($isCountry) {
            $this->selectedItem = $this->osmSearchResultsCountry[$index];
        } else {
            $this->selectedItem = $this->osmSearchResults[$index];
        }
        Storage::disk('geo')
               ->put('geojson_'.$this->selectedItem['osm_id'].'.json',
                   json_encode($this->selectedItem['geojson'], JSON_THROW_ON_ERROR));
        $input = storage_path('app/geo/geojson_'.$this->selectedItem['osm_id'].'.json');
        $output = storage_path('app/geo/output_'.$this->selectedItem['osm_id'].'.json');
        exec('mapshaper '.$input.' -simplify dp 4% -o '.$output);
        Storage::disk('geo')
               ->put(
                   'trimmed_'.$this->selectedItem['osm_id'].'.json',
                   str(Storage::disk('geo')
                              ->get('output_'.$this->selectedItem['osm_id'].'.json'))
                       ->after('{"type":"GeometryCollection", "geometries": [')
                       ->beforeLast(']}')
                       ->toString()
               );
        $this->meetup->city->osm_relation = $this->selectedItem;
        $this->meetup->city->simplified_geojson = json_decode(trim(Storage::disk('geo')
                                                                          ->get('trimmed_'.$this->selectedItem['osm_id'].'.json')),
            false, 512, JSON_THROW_ON_ERROR);
        $this->meetup->city->population = 0;
        $this->meetup->city->population_date = date('Y');
        $this->meetup->city->save();

        return to_route('osm.meetups.item', ['meetup' => $this->meetup]);
    }

    public function setPercent($percent)
    {
        $input = storage_path('app/geo/geojson_'.$this->selectedItem['osm_id'].'.json');
        $output = storage_path('app/geo/output_'.$this->selectedItem['osm_id'].'.json');
        exec('mapshaper '.$input.' -simplify dp '.$percent.'% -o '.$output);
        Storage::disk('geo')
               ->put(
                   'trimmed_'.$this->selectedItem['osm_id'].'.json',
                   str(Storage::disk('geo')
                              ->get('output_'.$this->selectedItem['osm_id'].'.json'))
                       ->after('{"type":"GeometryCollection", "geometries": [')
                       ->beforeLast(']}')
                       ->toString()
               );
        $this->meetup->city->simplified_geojson = json_decode(trim(Storage::disk('geo')
                                                                          ->get('trimmed_'.$this->selectedItem['osm_id'].'.json')),
            false, 512, JSON_THROW_ON_ERROR);
        $this->meetup->city->save();

        return to_route('osm.meetups.item', ['meetup' => $this->meetup]);
    }

    public function takePop($value)
    {
        $this->meetup->city->population = $value;
        $this->meetup->city->population_date = date('Y');
        $this->meetup->city->save();

        return to_route('osm.meetups.item', ['meetup' => $this->meetup]);
    }

    public function render()
    {
        return view('livewire.meetup.prepare-for-btc-map-item');
    }
}
