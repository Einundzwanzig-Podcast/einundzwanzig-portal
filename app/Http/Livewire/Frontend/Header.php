<?php

namespace App\Http\Livewire\Frontend;

use App\Models\BitcoinEvent;
use App\Models\City;
use App\Models\Country;
use App\Models\CourseEvent;
use App\Models\LibraryItem;
use App\Models\MeetupEvent;
use App\Models\OrangePill;
use App\Models\ProjectProposal;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Header extends Component
{
    public ?Country $country = null;

    public $currentRouteName;

    public string $c = 'de';

    public string $l = 'de';

    public string $timezone;

    public $bgColor = 'bg-21gray';

    protected $queryString = ['l'];

    protected $listeners = ['refresh' => '$refresh'];

    public function rules()
    {
        return [
            'c' => 'required',
            'l' => 'required',
            'timezone' => 'required',
        ];
    }

    public function mount()
    {
        $this->timezone = config('app.user-timezone');
        $this->l = Cookie::get('lang') ?: config('app.locale');
        $this->c = Cookie::get('country') ?: config('app.country');
        if (!$this->country) {
            $this->country = Country::query()
                ->where('code', $this->c)
                ->first();
        }
        $this->currentRouteName = Route::currentRouteName();
    }

    public function updatedTimezone($value)
    {
        auth()
            ->user()
            ->update(['timezone' => $value]);

        return redirect(request()->header('Referer'));
    }

    public function updatedC($value)
    {
        Cookie::queue('country', $value, 60 * 24 * 365);
        $url = str(request()->header('Referer'))->explode('/');
        $url[3] = $value;

        return redirect($url->implode('/'));
    }

    public function updatedL($value)
    {
        if ($value === 'nl-be') {
            $value = 'nl';
        }

        Cookie::queue('lang', $value, 60 * 24 * 365);

        return redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.frontend.header', [
            'news' => LibraryItem::query()
                ->with([
                    'createdBy.roles',
                    'lecturer',
                    'tags',
                ])
                ->where('type', 'markdown_article')
                ->where('approved', true)
                ->where('news', true)
                ->orderByDesc('created_at')
                ->take(2)
                ->get(),
            'meetups' => MeetupEvent::query()
                ->with([
                    'meetup.users',
                    'meetup.city.country',
                ])
                ->where('start', '>', now())
                ->orderBy('start')
                ->take(2)
                ->get(),
            'courseEvents' => CourseEvent::query()
                ->with([
                    'venue.city.country',
                    'course.lecturer',
                ])
                ->where('from', '>', now())
                ->orderBy('from')
                ->take(2)
                ->get(),
            'libraryItems' => LibraryItem::query()
                ->with([
                    'lecturer',
                ])
                ->where('type', '<>', 'markdown_article')
                ->orderByDesc('created_at')
                ->take(2)
                ->get(),
            'bitcoinEvents' => BitcoinEvent::query()
                ->with([
                    'venue',
                ])
                ->where('from', '>', now())
                ->orderBy('from')
                ->take(2)
                ->get(),
            'orangePills' => OrangePill::query()
                ->with([
                    'user',
                    'bookCase',
                ])
                ->orderByDesc('date')
                ->take(2)
                ->get(),
            'projectProposals' => ProjectProposal::query()
                ->with([
                    'votes',
                    'user',
                ])
                ->take(2)
                ->get(),
            'cities' => City::query()
                ->select(['latitude', 'longitude'])
                ->get(),
            'countries' => Country::query()
                ->select('id', 'name', 'code')
                ->orderBy('name')
                ->get()
                ->map(function (Country $country) {
                    $flag = config('countries.emoji_flags')[str($country->code)->upper()->toString()] ?? '';
                    $country->name = $flag . ' ' . $country->name;

                    return $country;
                }),
        ]);
    }
}
