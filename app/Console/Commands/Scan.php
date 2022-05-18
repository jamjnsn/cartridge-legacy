<?php

namespace App\Console\Commands;

use App\Debug;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;
use MarcReichel\IGDBLaravel\Models\Cover as IGDBCover;
use MarcReichel\IGDBLaravel\Models\Platform as IGDBPlatform;
use MarcReichel\IGDBLaravel\Models\Screenshot as IGDBScreenshot;
use MarcReichel\IGDBLaravel\Models\PlatformLogo as IGDBPlatformLogo;

use App\Models\File;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Support\Facades\Storage;

class Scan extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cart:scan';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checks games folder for unimported files and imports them.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('Started scan');
		Debug::log('Scanning for new files...');

		$gamesPath = config('cartridge.games_path');

		foreach (scandir($gamesPath) as $file) {
			$filePath = $gamesPath . '/' . $file;

			// Ignore dotfiles
			if (substr($file, 0, 1) != '.' && is_dir($filePath)) {
				$this->scanDirectory($filePath);
			}
		}

		return 0;
	}

	private function scanDirectory($dir)
	{
		$dirName = basename($dir);
		$relativeDir = str_replace(config('cartridge.games_path'), '', $dir);
		$platformData = IGDBPlatform::where('name', $dirName)->orWhere('alternative_name', $dirName)->first();
		sleep(config('cartridge.api_rate_delay'));

		if ($platformData == null) {
			return null;
		} else {

			$platform = $this->cachePlatform($platformData);
			Debug::log("Identified 📂$dir as 🕹️ {$platform->data->name}");

			foreach (scandir($dir) as $file) {
				if (!is_dir($file)) {
					$gamePath = $relativeDir . '/' . $file;

					if (!File::where('path', '=', $gamePath)->exists()) {
						$gameData = $this->identifyGame($file, $platform);

						if ($gameData == null) {
							Log::alert('No match found for ' . $file);
							Debug::log('No match found for ' . $file);
						} else {
							$game = $this->cacheGame($gameData, $platform);

							$this->createFileRecord(
								$gamePath,
								$platform,
								$game
							);

							Debug::log("Identified 💾$file as 🎮{$game->data->name}");
						}
					}
				}
			}
		}
	}

	private function createFileRecord($filePath, $platform, $game)
	{
		$file = File::firstOrNew(['path' => $filePath]);
		$file->path = $filePath;
		$file->platform_id = $platform->id;
		$file->game_id = $game->id;
		$file->save();
	}

	private function identifyGame($file, $platform)
	{
		$pathinfo = pathinfo($file);
		$filenameClean = preg_replace("/(?:\(.+\))?\s*(?:\[.+\])?\.(?:.*)/", "", $pathinfo['basename']);

		$games = IGDBGame::where('release_dates.platform', $platform->data->id);
		sleep(config('cartridge.api_rate_delay'));

		$match = $games->search($filenameClean)->first();
		return $match;
	}

	private function cachePlatform($data)
	{
		$platform = Platform::firstOrNew(['slug' => $data->slug]);
		$platform->slug = $data->slug;
		$platform->data = json_decode($data->toJson());
		$platform->save();

		$platformImagePath = 'platforms/' . $platform->slug;

		if (!Storage::disk('images')->exists($platformImagePath)) {
			$logo = IGDBPlatformLogo::where('id', '=', $data->platform_logo)->first();
			sleep(config('cartridge.api_rate_delay'));

			if ($logo != null) {
				$this->downloadImage($logo->image_id, $platformImagePath, 'cover_big');
			}
		}

		return $platform;
	}

	private function cacheGame($data)
	{
		$game = Game::firstOrNew(['slug' => $data->slug]);
		$game->slug = $data->slug;
		$game->data = json_decode($data->toJson());
		$game->save();

		$coverImagePath = 'covers/' . $game->slug;
		$screenshotPath = 'screenshots/' . $game->slug;

		if (!Storage::disk('images')->exists($coverImagePath)) {
			$cover = IGDBCover::where('id', '=', $data->cover)->first();
			sleep(config('cartridge.api_rate_delay'));

			if ($cover != null) {
				$this->downloadImage($cover->image_id, $coverImagePath, 'cover_big');
			}
		}

		if (!Storage::disk('images')->exists($screenshotPath)) {
			$screenshot = IGDBScreenshot::where('game', '=', $game->data->id)->first();
			sleep(config('cartridge.api_rate_delay'));

			if ($screenshot != null) {
				$this->downloadImage($screenshot->image_id, $screenshotPath, 'screenshot_big');
			}
		}

		return $game;
	}

	private function downloadImage($igdbImageId, $filePath, $size = 'cover_big')
	{
		$url = "https://images.igdb.com/igdb/image/upload/t_$size/$igdbImageId.png";

		$pathinfo = pathinfo($url);
		$contents = @file_get_contents($url);

		if ($contents) {
			Storage::disk('images')->put($filePath . '.' . $pathinfo['extension'], $contents);
		}
	}
}
