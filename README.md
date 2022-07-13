<div align="center">
  <img src="static/images/logo-full.png" alt="Logo" width="400" height="auto">
  <p align="center">
    A self-hosted game browser.
  </p>
</div>

## About
![Cartridge Screenshot](https://user-images.githubusercontent.com/1876231/169448529-54259dc2-0ad6-44eb-bc3e-df56220a6e64.png)
Cartridge is a convenient browser for your game collection with easy file downloads and automatically imported metadata and images. This project is designed to be self-hosted on your local server.

## Roadmap
Cartridge is currently in development and not yet ready for use. Here's a rough to-do list for an alpha release:

- ~~Game importer~~
- ~~Game browser & downloads~~
- Game search
- User administration (create, edit, delete)
- Manual IGDB match fix

## Development
Cartridge currently utilizes [Laravel Sail](https://laravel.com/docs/9.x/sail) for a convenient dev environment. By default, the app runs on port 80 and HMR runs on port 8080.

### Requirements
- [Composer](https://getcomposer.org/)
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- API key from [IGDB](https://api-docs.igdb.com/#about)
- Node 18 + npm (Easier with a Node version manager, such as [fnm](https://github.com/Schniz/fnm))

### Instructions
1. Clone the repository.  
	```sh
	git clone https://github.com/jamjnsn/cartridge.git
	```
2. Install dependencies  
	```sh
	composer install
	```
3. Create `.env` file.  
	```
	# Volumes
	GAMES_PATH=/path/to/roms

	# IGDB credentials
	TWITCH_CLIENT_ID=Your Client ID
	TWITCH_CLIENT_SECRET=Your Client Secret
	```
4. Start containers with Sail.  
	```sh
	alias sail="bash vendor/bin/sail" # Optional: add alias to your shell profile
	sail up -d
	```
5. Initialize application.  
	```sh
	sail artisan cart:init
	```
6. Start HMR.
	```
	sail npm run watch
	```

	

## Built With
* [Vue.js](https://vuejs.org/)
* [Laravel](https://laravel.com)
