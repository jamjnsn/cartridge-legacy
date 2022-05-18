<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platform;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $platforms = null;

        if ($search == '') {
            $platforms = Platform::all();
        } else {
            $platforms = Platform::where('data', 'like', '%' . $search . '%')->get();
        }

        return response()->json($platforms);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $platform = Platform::findBySlug($slug);

        if ($platform == null) {
            return response()->json('No results found.', 404);
        } else {
            return response()->json($platform);
        }
    }
}
