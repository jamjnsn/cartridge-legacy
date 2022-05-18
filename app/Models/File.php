<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    protected $appends = ['download_url', 'platform_name'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function getPlatformNameAttribute()
    {
        return $this->platform();
    }

    public function getDownloadUrlAttribute()
    {
        $pathinfo = pathinfo($this->path);

        return route('download', [
            'id' => $this->id,
            'filename' => $this->game->name . '.' . $pathinfo['extension']
        ]);
    }

    public function getPathExistsAttribute()
    {
        return Storage::disk('games')->exists($this->path);
    }
}
