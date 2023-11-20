<div x-data="nostrStart(@this)">
    <div class="p-16">
        <div
            wire:ignore
            x-data="{
                geoJsons: @entangle('geoJsons'),
                map: null,
                init() {
                    this.map = L.map(this.$refs.map).setView([51.1642, 10.4541194], 6);
                    var baseLayer = L.tileLayer(
                        'https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}{r}.png',{
                            attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors &copy; <a href=\'https://carto.com/attributions\'>CARTO</a>',
                        }
                    ).addTo(this.map);

                    function generateSimilarColor(baseColor, variance) {
                        var baseR = parseInt(baseColor.slice(1, 3), 16);
                        var baseG = parseInt(baseColor.slice(3, 5), 16);
                        var baseB = parseInt(baseColor.slice(5, 7), 16);
                        var newR = Math.floor((Math.random() - 0.5) * variance + baseR).toString(16).padStart(2, '0');
                        var newG = Math.floor((Math.random() - 0.5) * variance + baseG).toString(16).padStart(2, '0');
                        var newB = Math.floor((Math.random() - 0.5) * variance + baseB).toString(16).padStart(2, '0');
                        return `#${newR}${newG}${newB}`;
                    }

                    this.$watch('geoJsons', (geoJsons) => {
                        geoJsons.forEach((geoJson) => {
                            L.geoJSON(geoJson, {
                                style: function (feature) {
                                    return {
                                        color: generateSimilarColor('#0d579b', 20),
                                        fillColor: generateSimilarColor('#f7931a', 20),
                                        weight: 1,
                                        opacity: 1,
                                    };
                                },
                            }).addTo(this.map);
                        });
                    });
                }
            }"
        >
            <div class="w-full" x-ref="map" style="height: 70vh;"></div>
        </div>
    </div>
</div>
