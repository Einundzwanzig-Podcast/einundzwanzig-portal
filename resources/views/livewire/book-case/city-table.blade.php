<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">
            <livewire:tables.city-table :country="$country->code" type="bookCase"/>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
