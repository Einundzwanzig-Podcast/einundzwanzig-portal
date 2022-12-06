[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F03a51b88-6eab-491b-8b80-5183a78d0024%3Fdate%3D1%26commit%3D1&style=plastic)](https://forge.laravel.com)

## Development

### Installation

```cp .env.example .env```

```composer install```
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
