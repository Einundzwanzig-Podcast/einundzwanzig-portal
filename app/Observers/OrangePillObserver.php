<?php

namespace App\Observers;

use App\Models\OrangePill;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class OrangePillObserver
{
    use NostrTrait;

    /**
     * Handle the OrangePill "created" event.
     */
    public function created(OrangePill $orangePill): void
    {
        try {
            $text = sprintf("Ein neues Bitcoin-Buch liegt nun in diesem öffentlichen Bücherschrank:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Education #Einundzwanzig #gesundesgeld",
                $orangePill->bookCase->title,
                $orangePill->bookCase->address,
                url()->route('bookCases.comment.bookcase', ['country' => 'de', 'bookCase' => $orangePill->bookCase]),
            );
            $this->publishOnNostr($orangePill, $text);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the OrangePill "updated" event.
     */
    public function updated(OrangePill $orangePill): void
    {
        //
    }

    /**
     * Handle the OrangePill "deleted" event.
     */
    public function deleted(OrangePill $orangePill): void
    {
        //
    }

    /**
     * Handle the OrangePill "restored" event.
     */
    public function restored(OrangePill $orangePill): void
    {
        //
    }

    /**
     * Handle the OrangePill "force deleted" event.
     */
    public function forceDeleted(OrangePill $orangePill): void
    {
        //
    }
}
