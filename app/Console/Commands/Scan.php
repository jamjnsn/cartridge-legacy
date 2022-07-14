<?php

namespace App\Console\Commands;

use App\Debug;
use App\LogLevel;

use App\Console\CartridgeCommand;
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

class Scan extends CartridgeCommand
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
		$this->message('Scanning for new files', LogLevel::Info);

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
		sleep(config('cartridge.api_rate_delay'));

		// Get platform if it exists
		$platform = Platform::firstOrNew(['directory_name' => $dirName]);

		if($platform->exists) {
			// Get IGDB data from existing platform slug
			$platformData = IGDBPlatform::where('slug', $platform->slug)->first();

			// No IGDB platform data found
			if ($platformData == null) {
				$this->message("Existing platform with slug {$platform->slug} was not found on IGDB", LogLevel::Warning);
				return null;
			}
		} else {
			// Attempt to identify platform on IGDB based on directory name
			$platformData = IGDBPlatform::where('name', $dirName)->orWhere('alternative_name', $dirName)->first();

			// No IGDB platform data found
			if ($platformData == null) {
				$this->message("Could not identify platform for directory '{$dirName}'", LogLevel::Warning);
				return null;
			} else {
				$this->message("🕹️ Adding platform: {$platformData->name} from $dir", LogLevel::Info);

				// Add found platform data
				$platform->slug = $platformData->slug;
				$platform->name = $platformData->name;
				$platform->directory_name = $dirName;
			}
		}

		// Update platform metadata and save
		$platform->data = json_decode($platformData->toJson());
		$platform->save();

		// Fetch logo image if one doesn't exist
		if (!Storage::disk('public')->exists($platform->logo_path)) {
			$logo = IGDBPlatformLogo::where('id', '=', $platform->data->platform_logo)->first();
			sleep(config('cartridge.api_rate_delay'));

			if ($logo != null) {
				$this->downloadImage($logo->image_id, $platform->logo_path, 'cover_big');
			}
		}

		foreach (scandir($dir) as $file) {
			if (!is_dir($file)) {
				$gamePath = $relativeDir . '/' . $file;

				if (!File::where('path', '=', $gamePath)->exists()) {
					$gameData = $this->identifyGame($file, $platform);

					if ($gameData == null) {
						$this->message('No match found for ' . $gamePath, LogLevel::Warning);
					} else {
						$game = $this->updateGame($gameData, $file);

						$this->updateFileRecord(
							$gamePath,
							$platform,
							$game
						);
					}
				}
			}
		}
	}

	private function updateFileRecord($filePath, $platform, $game)
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

	private function updateGame($data, $filename)
	{
		$game = Game::firstOrNew(['slug' => $data->slug]);

		// Set game name and slug if this game is newly added
		if(!$game->exists) {
			$this->message("🎮 Adding game: {$data->name}", LogLevel::Info);
			$game->name = $data->name;
			$game->slug = $data->slug;
		}

		$game->data = json_decode($data->toJson());
		$game->save();

		$coverImagePath = 'covers/' . $game->slug;
		$screenshotPath = 'screenshots/' . $game->slug;

		if (!Storage::disk('public')->exists($coverImagePath)) {
			$cover = IGDBCover::where('id', '=', $data->cover)->first();
			sleep(config('cartridge.api_rate_delay'));

			if ($cover != null) {
				$this->downloadImage($cover->image_id, $coverImagePath, 'cover_big');
			}
		}

		if (!Storage::disk('public')->exists($screenshotPath)) {
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
			Storage::disk('public')->put($filePath . '.' . $pathinfo['extension'], $contents);
		}
	}
}
