<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Laravel\Scout\Searchable;

class Game extends Model
{
	use HasFactory;
	use Searchable;

	protected $fillable = ['data'];

	protected $casts = [
		'data' => 'object'
	];

	protected $appends = ['name', 'description', 'screenshot', 'cover'];

	public function toSearchableArray()
	{
		$searchable = $this->toArray();
		return $searchable;
	}

	public function files()
	{
		return $this->hasMany(File::class)->with('platform');
	}

	public function getDescriptionAttribute()
	{
		$description = $this->data->summary ?? $this->data->storyline ?? '';
		return nl2br(htmlentities($description));
	}

	public function getNameAttribute()
	{
		return $this->data->name ?? $this->data->alternate_name ?? '';
	}

	public function getCoverAttribute()
	{
		return Storage::disk('public')->url('/covers/' . $this->slug . '.png');
	}

	public function getScreenshotAttribute()
	{
		return Storage::disk('public')->url('/screenshots/' . $this->slug . '.png');
	}

	public static function whereFileExists()
	{
		return Game::whereIn('id', File::distinct()->select('game_id')->get());
	}

	public static function whereFileExistsForPlatform($platform)
	{
		$files = File::distinct()->where('platform_id', $platform->id)->select('game_id')->get();
		return Game::whereIn('id', $files);
	}

	public static function findBySlug($slug)
	{
		return Game::where('slug', $slug)->with('files')->first();
	}
}
