<?php

namespace App\Http\Livewire\Frontend;

use Illuminate\Support\Facades\Cookie;
use JoeDixon\Translation\Language;
use JoeDixon\Translation\Translation;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        if (str(Cookie::get('lang'))->contains('ey')) {
            Cookie::forget('lang');
        }
        $l = Cookie::get('lang', config('app.locale'));
        $language = Language::query()
                            ->where('language', $l)
                            ->first();
        if (!$language || str($l)->contains('ey')) {
            $language = Language::query()
                                ->where('language', config('app.locale'))
                                ->first();
        }
        $translated = $language->translations()
                               ->whereNotNull('value')
                               ->where('value', '<>', '')
                               ->count();
        $toTranslate = Translation::query()
                                  ->where('language_id', $language->id)
                                  ->count();
        $toTranslate = $toTranslate > 0 ? $toTranslate : 1;

        return view('livewire.frontend.footer', [
            'percentTranslated' => $l === 'en' ? 100 : round(($translated / $toTranslate) * 100),
            'language'          => $language,
        ]);
    }
}
