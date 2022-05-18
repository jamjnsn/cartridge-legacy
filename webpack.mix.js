const mix = require('laravel-mix')

mix.browserSync('http://localhost:' + process.env.APP_PORT)

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copy('./static/**/*', './public')
	.js('resources/js/app.js', 'public')
	.sass('resources/sass/app.scss', 'public')
	.version()
