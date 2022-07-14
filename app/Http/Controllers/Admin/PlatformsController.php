<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PlatformsController extends Controller
{
		public function index(Request $request)
		{
			$platforms = Platform::all();
			return view('admin.platforms.index', ['platforms' => $platforms]);
		}

		public function create()
		{
			return view('admin.platforms.modify', ['platform' => new Platform(), 'is_edit_mode' => false]);
		}

		public function store()
		{
			//
		}

		public function show(Platform $platform)
		{
			//
		}

		public function edit(Platform $platform)
		{
			return view('admin.platforms.modify', ['is_edit_mode' => true, 'platform' => $platform]);
		}

		public function update(Platform $platform)
		{
			//
		}

		public function destroy(Platform $platform)
		{
			//
		}
}
