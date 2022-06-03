const mix = require('laravel-mix')
const path = require('path')

mix.webpackConfig({
	resolve: {
		alias: {
			'@': path.resolve('resources/sass'),
		},
	},
	module: {
		rules: [
			{
				test: /\.scss$/,
				loader: 'sass-loader',
				options: {
					additionalData: `
					  @import "~@/_variables.scss";
				`,
				},
			},
		],
	},
})

mix.options({
    hmrOptions: {
        host: '0.0.0.0',
		port: 8080
    },
})

mix.copy('static', 'public')

mix.js('resources/js/app.js', 'public')
	.sass('resources/sass/app.scss', 'public')
	.vue()
	.sourceMaps()
	.version()
