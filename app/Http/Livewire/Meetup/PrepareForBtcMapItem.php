<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Meetup;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class PrepareForBtcMapItem extends Component
{
    public Meetup $meetup;

    public $wikipediaSearchResults;
    public $osmSearchResults;
    public $osmSearchResultsState;
    public $osmSearchResultsCountry;

    public $selectedItem;

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

            $wikipediaUrl = 'https://query.wikidata.org/sparql?query=SELECT%20%3Fpopulation%20WHERE%20%7B%0A%20%20SERVICE%20wikibase%3Amwapi%20%7B%0A%20%20%20%20%20%20bd%3AserviceParam%20mwapi%3Asearch%20%22'.urlencode($this->meetup->city->name).'%22%20.%20%20%20%20%0A%20%20%20%20%20%20bd%3AserviceParam%20mwapi%3Alanguage%20%22en%22%20.%20%20%20%20%0A%20%20%20%20%20%20bd%3AserviceParam%20wikibase%3Aapi%20%22EntitySearch%22%20.%0A%20%20%20%20%20%20bd%3AserviceParam%20wikibase%3Aendpoint%20%22www.wikidata.org%22%20.%0A%20%20%20%20%20%20bd%3AserviceParam%20wikibase%3Alimit%201%20.%0A%20%20%20%20%20%20%3Fitem%20wikibase%3AapiOutputItem%20mwapi%3Aitem%20.%0A%20%20%7D%0A%20%20%3Fitem%20wdt%3AP1082%20%3Fpopulation%0A%7D';
            $response = Http::acceptJson()
                            ->get(
                                $wikipediaUrl
                            );
            $this->wikipediaSearchResults = $response->json();
        }
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
