<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'name', 'slug', 'directory_name'];

    protected $casts = [
        'data' => 'object'
    ];

    public function getGamesAttribute()
    {
        return Game::whereFileExistsForPlatform($this)->get();
    }

	public function getLogoPathAttribute() {
		return 'platforms/' . $this->slug;
	}

    public static function whereFileExists()
    {
        return Platform::whereIn('id', File::distinct()->select('platform_id')->get());
    }

    public static function findBySlug($slug)
    {
        return Platform::where('slug', $slug)->first();
    }
}
