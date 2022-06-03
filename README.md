<div align="center">
  <img src="static/images/logo-full.png" alt="Logo" width="400" height="auto">
  <p align="center">
    A self-hosted game browser.
  </p>
</div>

## About
![Cartridge Screenshot](https://user-images.githubusercontent.com/1876231/169448529-54259dc2-0ad6-44eb-bc3e-df56220a6e64.png)
Cartridge is a convenient browser for your game collection with easy file downloads and automatically imported metadata and images. This project is designed to be self-hosted on your local server.

## Development
Currently, development is intended to be done utilizing Laravel Sail.

### Clone the repository
```
git clone https://github.com/jamjnsn/cartridge.git && cd cartridge
```

### Provide needed env variables
```
cp .env.example .env
nano .env
```

### Start app using Laravel Sail
```
sail up -d
sail artisan cart:init
```

## Built With
* [Vue.js](https://vuejs.org/)
* [Laravel](https://laravel.com)
