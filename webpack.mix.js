const mix = require('laravel-mix');
mix.options({
    postCss: [
      require('autoprefixer')
    ],
    processCssUrls: false
  });
  mix.browserSync('http://localhost/staff-management');
