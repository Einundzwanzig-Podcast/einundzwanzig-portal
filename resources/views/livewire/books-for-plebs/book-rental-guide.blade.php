<div>
    <h1 class="text-white text-xl">Test</h1>
</div>

<div class="h-screen w-full">

    <livewire:frontend.header :country="\App\Models\Country::query()->where('code', 'de')->first()"/>

    <div class="px-2 sm:px-24">
        <!-- Hier coden/arbeiten -->
        <div class="flex space-x-2 justify-between">
            <h1 class="text-white text-xl">Test</h1>
            <h1 class="text-white text-xl">Test</h1>
            <h1 class="text-white text-xl">Test</h1>
            <h1 class="text-white text-xl">Test</h1>
        </div>
        
    </div>

    <livewire:frontend.footer/>
</div>

