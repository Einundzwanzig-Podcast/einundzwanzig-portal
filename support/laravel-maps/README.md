# Maps for your Laravel application

[![GitLab Repository](https://img.shields.io/badge/GitLab-gonoware/laravel--maps-blue.svg?logo=gitlab&style=flat-square&longCache=true)](https://gitlab.com/gonoware/laravel-maps)
[![Laravel Version](https://img.shields.io/badge/Laravel-9-blue.svg?logo=laravel&style=flat-square&longCache=true)]()
[![Latest Stable Version](https://poser.pugx.org/gonoware/laravel-maps/v/stable?format=flat-square)](https://packagist.org/packages/gonoware/laravel-maps)
[![StyleCI](https://gitlab.styleci.io/repos/8146646/shield)](https://gitlab.styleci.io/repos/8146646)
[![License](https://poser.pugx.org/gonoware/laravel-maps/license?format=flat-square)](https://packagist.org/packages/gonoware/laravel-maps)
[![Total Downloads](https://poser.pugx.org/gonoware/laravel-maps/downloads?format=flat-square)](https://packagist.org/packages/gonoware/laravel-maps)

Using this package you can easily display maps on your website.

Supported map services: 
 * Google Maps
 * OpenStreetMap
 * Bing Maps
 * MapQuest
 * Yandex Maps
 * MapKit (beta)

> Note: Yandex Maps API does not work in Chrome.

## Features
| | Google Maps | OpenStreetMap | Bing Maps | MapQuest | Yandex Maps | MapKit |  
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| [Map](#basic-map) | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ |
| [Markers](#map-with-markers) | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ |
| [Marker Links](#marker-links) | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ |
| [Marker Popups](#marker-popups) | ✔ | ✔ | ✔ | ✔ | ✔ | ❌ |
| [Custom Marker Icons](#custom-marker-icons) | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ |
| [Marker Click Event](#marker-clicked) | ✔ | ✔ | ✔ | ✔ | ✔ | ✔ | 

## Installation

This package can be installed through Composer.
```bash
composer require gonoware/laravel-maps
```

Publish the compiled assets to `public/vendor/maps` with one of these 
commands:
```bash
php artisan vendor:publish --tag=maps
```
```bash
php artisan vendor:publish --provider="GoNoWare\Maps\MapsServiceProvider" --tag=public
```
> When updating, use the `--force` switch to overwrite existing assets:
```bash
php artisan vendor:publish --tag=maps --force
```

Optionally, you can also publish the config file of this package with this 
command to `config/vendor/maps.php`:
```bash
php artisan vendor:publish --provider="GoNoWare\Maps\MapsServiceProvider" --tag=config
```


## Usage

Load the map styles by adding the following directive to your
Blade template before the `</head>` closing tag.
```php
@mapstyles
```

Then add the following directive to your Blade template
before the `</body>` closing tag, to load the map scripts.
```php
@mapscripts
```

### Basic Map
Display a map by adding the `@map` directive to your Blade template.
```php
@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
])
```

### Map With Markers
You can also show markers / pins / annotations:
```php
@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
    'markers' => [
        [
            'title' => 'Go NoWare',
            'lat' => 48.134664,
            'lng' => 11.555220,
        ],
    ],
])
```

### Marker Links
Open a url when a marker is clicked.
```php
@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
    'markers' => [
        [
            'title' => 'Go NoWare',
            'lat' => 48.134664,
            'lng' => 11.555220,
            'url' => 'https://gonoware.com',
        ],
    ],
])
```

### Marker Popups
Show a popup when a marker is clicked. The `popup` attribute may contain HTML markup.
```php
@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
    'markers' => [
        [
            'title' => 'Go NoWare',
            'lat' => 48.134664,
            'lng' => 11.555220,
            'popup' => '<h3>Details</h3><p>Click <a href="https://gonoware.com">here</a>.</p>',
        ],
    ],
])
```

### Custom Marker Icons
Show a custom marker icon. Absolute and relative URLs are supported.
```php
@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
    'markers' => [
        [
            'title' => 'Go NoWare',
            'lat' => 48.134664,
            'lng' => 11.555220,
            'url' => 'https://gonoware.com',
            'icon' => 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
        ],
    ],
])
```

Additionally you may also specify the icon image size and anchor in pixels. The image will be aligned so that the tip of the icon is at the marker's geographical location.
```php
@map([
    'lat' => 48.134664,
    'lng' => 11.555220,
    'zoom' => 6,
    'markers' => [
        [
            'title' => 'Go NoWare',
            'lat' => 48.134664,
            'lng' => 11.555220,
            'url' => 'https://gonoware.com',
            'icon' => 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
            'icon_size' => [20, 32],
            'icon_anchor' => [0, 32],
        ],
    ],
])
```

## Styling

To adjust the height of the map use CSS:
```css
.gnw-map-service {
    height: 750px;
}
```

Change the background of the map container:
```css
.gnw-map-service__osm {
    background: rgb(221, 221, 221);
}
```

Fade in by default when using Bootstrap 3.3.7 or 4+. To replicate or modify the animation use following CSS:
```css
.gnw-map.fade {
    transition: opacity .15s linear;
}
.gnw-map.fade:not(.show) {
    opacity: 0;
}
```

## Events

### Map Initialized
The event `LaravelMaps:MapInitialized` will be dispatched when a map and its markers were initialized. The DOM element, map, 
markers and service name can be accessed via the event details.
```js
window.addEventListener('LaravelMaps:MapInitialized', function (event) {
   var element = event.detail.element;
   var map = event.detail.map;
   var markers = event.detail.markers;
   var service = event.detail.service;
   console.log('map initialized', element, map, markers, service);
});
```
Please refer to the respective documentation for advanced customization:
 * [Google Maps](https://developers.google.com/maps/documentation/javascript/tutorial)
 * [OpenStreetMap](https://leafletjs.com/reference-1.6.0.html)
 * [Bing Maps](https://leafletjs.com/reference-1.6.0.html)
 * [MapQuest](https://leafletjs.com/reference-1.6.0.html)
 * [Yandex Maps](https://tech.yandex.com/maps/jsapi/)
 * [MapKit (beta)](https://developer.apple.com/documentation/mapkitjs)

### Marker Clicked
The event `LaravelMaps:MarkerClicked` will be dispatched when a marker was clicked. The DOM element, map, marker and 
service name can be accessed via the event details.
```js
window.addEventListener('LaravelMaps:MarkerClicked', function (event) {
    var element = event.detail.element;
    var map = event.detail.map;
    var marker = event.detail.marker;
    var service = event.detail.service;
    console.log('marker clicked', element, map, marker, service);
});
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security

If you discover any security related issues, please email [em@gonoware.com](mailto:em@gonoware.com) 
instead of using the issue tracker.


## Credits

- [Emanuel Mutschlechner](https://gitlab.com/emanuel)
- [Benedikt Tuschter](https://gitlab.com/benedikttuschter)
- [All Contributors](https://gitlab.com/gonoware/laravel-maps/graphs/master)


## License

[MIT](LICENSE.md)
 
Copyright (c) 2018-present Go NoWare
 
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgitlab.com%2Fgonoware%2Flaravel-maps.svg?type=large)](https://app.fossa.io/projects/git%2Bgitlab.com%2Fgonoware%2Flaravel-maps?ref=badge_large)
