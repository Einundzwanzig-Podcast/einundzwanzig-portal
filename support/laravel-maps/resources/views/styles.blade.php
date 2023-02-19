@if ($enabled)
    @if ($service == 'osm' || $service == 'bing' || $service == 'mapquest')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" type="text/css">
    @endif
    @if ($service == 'mapquest')
        <link rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest-core.css" type="text/css">
    @endif
    <link rel="stylesheet" href="{{ asset(mix('css/index.css', 'vendor/maps')) }}" type="text/css">
@endif
