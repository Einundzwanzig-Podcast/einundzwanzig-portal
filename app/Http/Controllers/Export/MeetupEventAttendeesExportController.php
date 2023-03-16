<?php

namespace App\Http\Controllers\Export;

use App\Exports\MeetupEventAttendeesExport;
use App\Http\Controllers\Controller;
use App\Models\MeetupEvent;
use Illuminate\Http\Request;

class MeetupEventAttendeesExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, MeetupEvent $meetupEvent)
    {
        return (new MeetupEventAttendeesExport($meetupEvent))->download($meetupEvent->start->toDateString().'_'.$meetupEvent->meetup->slug.'.xlsx');
    }
}
