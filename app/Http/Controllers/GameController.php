<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Platform;
use Illuminate\Http\Request;

class GameController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$limit = $request->input('limit', config('cartridge.default_per_page'));
		$search = $request->input('search', '');

		$query = Game::limit($limit)->with('files');

		if ($search != '') {
			// Apply search
		}

		return response()->json($query->get());
	}

	public function search(Request $request, $query)
	{
		$results = Game::search($query)->get();
		return response()->json($results);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $slug)
	{
		$game = Game::findBySlug($slug);

		if ($game == null) {
			return response()->json('No results found.', 404);
		} else {
			return response()->json($game);
		}
	}
}
