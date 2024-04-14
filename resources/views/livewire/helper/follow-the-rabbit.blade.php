<div class="h-screen w-full">

    <livewire:frontend.header :country="\App\Models\Country::query()->where('code', 'de')->first()"/>

    <div class="px-2 sm:px-24">
        <iframe allowfullscreen="true" src="https://www.easyzoom.com/imageaccess/1322a81aa55e4fd6a3188f6217476652" width="100%"
                style="height: 90vh;"></iframe>
    </div>

    <livewire:frontend.footer/>
</div>
