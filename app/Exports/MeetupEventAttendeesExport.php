<?php

namespace App\Exports;

use App\Models\MeetupEvent;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MeetupEventAttendeesExport implements FromView, ShouldAutoSize
{
    use Exportable;

    public function __construct(public MeetupEvent $meetupEvent)
    {
    }

    private function mapAttendees($collection, $status) {
        return $collection->map(function ($value) use ($status) {
            if (str($value)->contains('anon_')) {
                $id = -1;
            } else {
                $id = str($value)
                    ->before('|')
                    ->after('id_')
                    ->toString();
            }

            return [
                'id'   => $id,
                'status' => $status,
                'user' => $id > 0 ? User::withoutEvents(static fn() => User::query()
                                                                           ->select([
                                                                               'id',
                                                                               'name',
                                                                               'profile_photo_path',
                                                                           ])
                                                                           ->find($id)
                                                                           ?->append('profile_photo_url')
                                                                           ->toArray())
                    : null,
                'name' => str($value)
                    ->after('|')
                    ->toString(),
            ];
        })
                          ->toArray();
    }

    public function view(): View
    {
        $attendees = $this->mapAttendees(collect($this->meetupEvent->attendees), __('Participation confirmed'));
        $mightAttendees = $this->mapAttendees(collect($this->meetupEvent->might_attendees), __('Perhaps'));

        return view('exports.meetupEventsAttendees', [
            'attendees' => array_merge($attendees, $mightAttendees),
        ]);
    }
}
