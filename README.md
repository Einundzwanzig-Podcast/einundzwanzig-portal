[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Ff25a1151-9c87-4f14-9943-17d05fa736c9%3Fdate%3D1%26commit%3D1&style=plastic)](https://forge.laravel.com)

## Development

### Installation

```cp .env.example .env```

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
*(you need a valid Laravel Nova license)*

#### Start docker development containers

```vendor/bin/sail up -d```

#### Install node dependencies

```vendor/bin/sail yarn install```

#### Start compiling watcher

```vendor/bin/sail yarn dev```

#### Compile assets

```vendor/bin/sail yarn build```

#### Update dependencies

```vendor/bin/sail yarn install```

## Contributing

WIP

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to Benjamin Takats
via [bt@affekt.de](mailto:bt@affekt.de). All security vulnerabilities will be promptly addressed.

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
