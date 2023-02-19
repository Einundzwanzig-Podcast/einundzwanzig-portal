<?php

namespace App\Rules;

use App\Models\MeetupEvent;
use Closure;
use Illuminate\Contracts\Validation\InvokableRule;

class UniqueAttendeeName implements InvokableRule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(public MeetupEvent $meetupEvent)
    {
        //
    }

    public function __invoke(string $attribute, mixed $value, Closure $fail)
    {
        $this->meetupEvent->refresh();
        $attendees = collect($this->meetupEvent->attendees);
        $mightAttendees = collect($this->meetupEvent->might_attendees);
        $isInAttendees = $attendees
            ->contains(fn ($v) => str($v)
                                     ->after('|')
                                     ->lower()
                                     ->toString() === str($value)
                                     ->lower()
                                     ->toString());
        $isInMightAttendees = $mightAttendees
            ->contains(fn ($v) => str($v)
                                     ->after('|')
                                     ->lower()
                                     ->toString() === str($value)
                                     ->lower()
                                     ->toString());
        if ($isInAttendees) {
            $fail('The name is already taken.');
        }
        if ($isInMightAttendees) {
            $fail('The name is already taken.');
        }
    }
}
