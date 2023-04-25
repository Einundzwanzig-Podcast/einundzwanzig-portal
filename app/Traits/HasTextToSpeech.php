<?php

namespace App\Traits;

use App\CodeIsSpeech;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

trait HasTextToSpeech
{
    use CodeIsSpeech;

    public function mountHasTextToSpeech()
    {
        $id = str(Route::currentRouteName())
            ->replace('.', ' ')
            ->camel()
            ->toString();
        $text = $this->$id();
        File::put(storage_path('app/public/tts/'.$id.'.txt'), $text);

        if (
            in_array($id, [
                //'authLn',
                'profileLnbits',
                'meetupWorld',
                'bitcoinEventTableBitcoinEvent',
                'libraryTableLibraryItems',
                'schoolTableCourse',
            ])
            && File::exists(storage_path('app/public/tts/'.$id.'.wav'))
        ) {
            dispatch(new \App\Jobs\CodeIsSpeech($id, false))->delay(now()->addSecond());
        } elseif (in_array($id, ['welcome']) && auth()->check()) {

        } else {
            dispatch(new \App\Jobs\CodeIsSpeech($id))->delay(now()->addSecond());
        }
    }
}
