<div class="w-full mb-4 md:w-auto md:mb-0">
    <x-button :href="route('project.projectProposal.form', ['country' => $country, 'projectProposal' => null])">
        <i class="fa fa-solid fa-plus"></i>
        {{ __('Submit project for funding') }}
    </x-button>
</div>
