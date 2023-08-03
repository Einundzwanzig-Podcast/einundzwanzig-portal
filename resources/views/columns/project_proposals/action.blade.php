<div class="flex flex-col space-y-1">
    @can('update', $row)
        <div>
            <x-button xs amber
                      :href="route('project.projectProposal.form', ['country' => $country, 'projectProposal' => $row])">
                <i class="fa fa-solid fa-edit mr-2"></i>
                {{ __('Edit') }}
            </x-button>
        </div>
    @endcan
    @auth
        <div>
            <x-button class="whitespace-nowrap" xs black :href="route('voting.projectFunding', ['projectProposal' => $row])">
                <i class="fa fa-solid fa-check-to-slot mr-2"></i>
                {{ __('Vote') }} [0]
            </x-button>
        </div>
        @else
        <div>
            <x-badge>{{ __('for voting you have to be logged in') }}</x-badge>
        </div>
    @endauth
</div>
