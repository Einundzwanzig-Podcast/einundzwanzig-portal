<div class="flex flex-col space-y-1">
    <div>
        <x-button xs class="whitespace-nowrap" amber
                  wire:click="viewHistoryModal({{ $row->id }})">{{ __('Register') }}</x-button>
    </div>
    @can('update', $row)
        <div>
            <x-button xs class="whitespace-nowrap" amber
                      :href="route('course.form.courseEvent', ['courseEvent' => $row])">
                <i class="fa-solid fa-edit"></i>
                {{ __('Edit') }}
            </x-button>
        </div>
    @endcan
</div>
