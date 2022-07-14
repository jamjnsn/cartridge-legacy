<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StorePlatform;
use Illuminate\Validation\Rule;

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

		public function store(Request $request)
		{
			$validated = $request->validate([
				'slug' => [
					'required',
					Rule::unique('platforms')
				],
				'name' => [
					'required',
					Rule::unique('platforms')
				],
				'directory_name' => [
					'required',
					Rule::unique('platforms')
				],
			]);

			$validated['data'] = [];
			Platform::create($validated);
			return redirect()->route('platforms.index');
		}

		public function show(Platform $platform)
		{
			//
		}

		public function edit(Platform $platform)
		{
			return view('admin.platforms.modify', ['is_edit_mode' => true, 'platform' => $platform]);
		}

		public function update(Platform $platform, Request $request)
		{
			$validated = $request->validate([
				'slug' => [
					'required',
					Rule::unique('platforms')->ignore($platform->id)
				],
				'name' => [
					'required',
					Rule::unique('platforms')->ignore($platform->id)
				],
				'directory_name' => [
					'required',
					Rule::unique('platforms')->ignore($platform->id)
				],
			]);

			$platform->update($validated);
			return redirect()->route('platforms.index');
		}

		public function destroy(Platform $platform, Request $request)
		{
			$platform_name = $platform->name;
			$platform->delete();
			$request->session()->flash('status', ['type' => 'error', 'message' => 'Deleted platform ' . $platform_name . '.']);
			return redirect()->route('platforms.index');
		}
}
