const mix = require('laravel-mix');

mix.sass('sass/style.scss', 'style.css')
  .options({
    processCssUrls: false,
  });