const mix = require('laravel-mix');

mix.setPublicPath('public')
  .js('resources/js/index.js', 'js')
  .sass('resources/sass/index.scss', 'css')
  .copy('resources/img/*.png', 'img')
  .version('img');
