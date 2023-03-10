<div class="flex flex-col space-y-1">
    @can('update', $row)
        <div>
            <x-button xs amber :href="route('project.projectProposal.form', ['country' => $country, 'projectProposal' => $row])">
                <i class="fa fa-thin fa-edit mr-2"></i>
                {{ __('Edit') }}
            </x-button>
        </div>
    @endcan
    <div>
        <x-button xs black :href="route('voting.projectFunding', ['projectProposal' => $row])">
            <i class="fa fa-thin fa-check-to-slot mr-2"></i>
            {{ __('Vote') }} [0]
        </x-button>
    </div>
</div>
