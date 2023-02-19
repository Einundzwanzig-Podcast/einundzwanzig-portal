@if ($enabled)
    <div class="gnw-map-service gnw-map-service__{{ $service }}">
        <div class="gnw-map fade" data-map-{{ $service }}="{{ json_encode(compact('lat', 'lng', 'zoom')) }}" data-map-service="{{ json_encode(config('vendor.maps.services.'.$service)) }}" data-map-markers="{{ json_encode($markers ?? []) }}"></div>
    </div>
{{--
    <div class="col-lg-12"></div>
    <div class="clear-fix"></div>

    <div class="col-lg-12"></div>
    <div class="clear-fix"></div>

    <iframe class="map" width="800" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ $key ?? '' }}&q={{ $lat }},{{ $lng }}&center={{ $lat }},{{ $lng }}&zoom={{ $zoom }}" scrolling="no">
    </iframe>

    <div class="col-lg-12"></div>
    <div class="clear-fix"></div>

    <div class="map-container fade in">
        <iframe class="map" width="800" height="800" frameborder="0" style="border:0" src="https://www.bing.com/maps/embed?h=800&w=800&cp={{ $lat }}~{{ $lng }}&lvl={{ $zoom }}&typ=d&sty=r&src=SHELL&FORM=MBEDV8" scrolling="no">
        </iframe>
    </div>
    --}}
@endif
