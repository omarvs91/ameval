// webpack.mix.js

let mix = require('laravel-mix');

// Uncomment for stats/debugging
// mix.webpackConfig({
//   stats: {
//        children: true
//   }
// });

mix
  .js(['src/js/theme.js'], '.')
  .sass('src/scss/style.scss', '.')
    .options({
      processCssUrls: false,
    });