[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Ff25a1151-9c87-4f14-9943-17d05fa736c9%3Fdate%3D1%26commit%3D1&style=plastic)](https://forge.laravel.com)

## Contributing and Proposals

[https://gitworkshop.dev/r/naddr1qq2x26tww4hxg7nhv9h856t894cx7un5v9kqzrthwden5te0dehhxtnvdakqygq2man5whxvtjj9dlfsytjx7h2jd6c27c5yh7z5jnqd67z870jsxvpsgqqqw7vs969w83](https://gitworkshop.dev/r/naddr1qq2x26tww4hxg7nhv9h856t894cx7un5v9kqzrthwden5te0dehhxtnvdakqygq2man5whxvtjj9dlfsytjx7h2jd6c27c5yh7z5jnqd67z870jsxvpsgqqqw7vs969w83)

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
*(you need a valid Laravel Nova license or send a message to [SimpleX - The Ben](https://simplex.chat/contact#/?v=2-4&smp=smp%3A%2F%2Fhejn2gVIqNU6xjtGM3OwQeuk8ZEbDXVJXAlnSBJBWUA%3D%40smp16.simplex.im%2FO9kuNebRK1RwpKSE73p_XDMq9-XOcuI3%23%2F%3Fv%3D1-2%26dh%3DMCowBQYDK2VuAyEAqccFXvqGHCBpm7Iq1r9mGiHe82RolsPHXI8KupC9fRQ%253D%26srv%3Dp3ktngodzi6qrf7w64mmde3syuzrv57y55hxabqcq3l5p6oi7yzze6qd.onion))*

#### Start docker development containers

```vendor/bin/sail up -d```

### Migrate and seed the database

```./vendor/bin/sail artisan migrate:fresh --seed```

### Laravel storage link

```./vendor/bin/sail artisan storage:link```

#### Install node dependencies

```vendor/bin/sail yarn install```

#### Start just in time compiler

```vendor/bin/sail yarn dev```

#### Update dependencies

```vendor/bin/sail yarn```

## Security Vulnerabilities

If you discover a security vulnerability within this project, please go to [https://gitworkshop.dev/r/naddr1qq2x26tww4hxg7nhv9h856t894cx7un5v9kqzrthwden5te0dehhxtnvdakqygq2man5whxvtjj9dlfsytjx7h2jd6c27c5yh7z5jnqd67z870jsxvpsgqqqw7vs969w83](https://gitworkshop.dev/r/naddr1qq2x26tww4hxg7nhv9h856t894cx7un5v9kqzrthwden5te0dehhxtnvdakqygq2man5whxvtjj9dlfsytjx7h2jd6c27c5yh7z5jnqd67z870jsxvpsgqqqw7vs969w83). All security vulnerabilities will be promptly addressed.

## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
