<?php

namespace App\Observers;

use App\Models\OrangePill;
use App\Traits\TwitterTrait;

class OrangePillObserver
{
    use TwitterTrait;

    /**
     * Handle the OrangePill "created" event.
     *
     * @param  \App\Models\OrangePill  $orangePill
     *
     * @return void
     */
    public function created(OrangePill $orangePill)
    {
//        if (config('feeds.services.twitterAccountId')) {
//            $this->setNewAccessToken(1);
//
//            $text = sprintf("Ein neues Bitcoin-Buch liegt nun in diesem öffentlichen Bücherschrank:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Education #Einundzwanzig #gesundesgeld",
//                $orangePill->bookCase->title,
//                $orangePill->bookCase->address,
//                url()->route('bookCases.comment.bookcase', ['country' => 'de', 'bookCase' => $orangePill->bookCase]),
//            );
//
//            $this->postTweet($text);
//        }
    }

    /**
     * Handle the OrangePill "updated" event.
     *
     * @param  \App\Models\OrangePill  $orangePill
     *
     * @return void
     */
    public function updated(OrangePill $orangePill)
    {
        //
    }

    /**
     * Handle the OrangePill "deleted" event.
     *
     * @param  \App\Models\OrangePill  $orangePill
     *
     * @return void
     */
    public function deleted(OrangePill $orangePill)
    {
        //
    }

    /**
     * Handle the OrangePill "restored" event.
     *
     * @param  \App\Models\OrangePill  $orangePill
     *
     * @return void
     */
    public function restored(OrangePill $orangePill)
    {
        //
    }

    /**
     * Handle the OrangePill "force deleted" event.
     *
     * @param  \App\Models\OrangePill  $orangePill
     *
     * @return void
     */
    public function forceDeleted(OrangePill $orangePill)
    {
        //
    }
}
