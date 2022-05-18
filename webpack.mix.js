const mix = require('laravel-mix')

mix.browserSync('http://localhost:' + process.env.APP_PORT)

mix.copy('./static/**/*', './public')
	.js('resources/js/app.js', 'public')
	.sass('resources/sass/app.scss', 'public')
	.vue()
	.version()
