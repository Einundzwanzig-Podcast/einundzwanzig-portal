<div class="bg-21gray flex flex-col h-screen justify-between">
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">

            <h1 class="font-bold dark:text-white">
                {{ __('Orange Pill Heatmap') }}
            </h1>

            <div
                x-data="{
                    data: @js($heatmap_data),
                    init() {

                        const map = L.map($refs.map).setView([50.5, 30.5], 8);

                        L.tileLayer.provider('Stamen.Toner').addTo(map);

                        var heat = L.heatLayer(this.data, {
                            blur: 5,
                            minOpacity: 0.2,
                            radius: 25,
                            gradient: {0.4: '#FABE75', 0.65: '#F9A949', 1: '#F7931A'}
                        }).addTo(map);
                    }
                }"
            >
                <div x-ref="map" style="height: 70vh;"></div>
            </div>

        </div>
    </section>
</div>
