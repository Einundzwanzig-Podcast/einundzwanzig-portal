<div class="flex flex-col space-y-1">
    @if($row->course_events_count > 0)
        <div>
            <x-button class="whitespace-nowrap" xs amber wire:click="courseSearch({{ $row->id }})">
                {{ __('Show dates') }} [{{ $row->course_events_count }}]
            </x-button>
        </div>
    @else
        <div>
            <x-button class="whitespace-nowrap" xs outline wire:click="courseSearch({{ $row->id }})">
                {{ __('Show dates') }}
            </x-button>
        </div>
    @endif
    @can('update', $row)
        <div>
            <x-button class="whitespace-nowrap" amber xs :href="route('course.form.course', ['course' => $row])">
                <i class="fa fa-thin fa-edit"></i>
                {{ __('Edit') }}
            </x-button>
        </div>
    @endcan
</div>
