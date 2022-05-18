<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    function download($file_id, $filename)
    {
        $file = File::where('id', $file_id)->first();
        return Storage::disk('games')->download($file->path, $filename);
    }
}
