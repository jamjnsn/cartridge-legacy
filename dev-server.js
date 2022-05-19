require('dotenv').config()

const chalk = require('chalk')
const { spawn } = require('child_process')

const colors = {
	mix: chalk.green,
	server: chalk.blue,
}

function log(source, data) {
	let color = colors[source]

	String(data)
		.split('\n')
		.forEach((line) => {
			console.log(` ${color('|')} ${line}`)
		})
}

// Run mix
const mix = spawn('npx', ['mix', 'watch', '--hot'])

mix.stdout.on('data', (data) => {
	log('mix', data)
})

mix.stderr.on('data', (data) => {
	log('mix', chalk.red(data))
})

mix.on('error', (error) => {
	log('mix', chalk.red(error.message))
})

mix.on('close', (code) => {
	log('mix', `Process exited with code ${code}`)
})

// PHP dev server
const server = spawn('php', [
	'artisan',
	'serve',
	'--port',
	process.env.APP_PORT,
])

server.stdout.on('data', (data) => {
	log('server', data)
})

server.stderr.on('data', (data) => {
	log('server', chalk.red(data))
})

server.on('error', (error) => {
	log('server', chalk.red(error.message))
})

server.on('close', (code) => {
	log('server', `Process exited with code ${code}`)
})
