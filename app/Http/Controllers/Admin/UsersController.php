<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
	public function __construct()
	{
	}

	public function index(Request $request)
	{
		$users = User::all();
		return view('admin.users.index', ['users' => $users]);
	}

	public function new()
	{
		return view('admin.users.modify', ['user' => new User(), 'is_edit_mode' => false]);
	}

	public function create(Request $request)
	{
		$rules = User::$validations;
		$rules['name'] .= '|required';
		$rules['password'] .= '|confirmed|required';

		$validated = $request->validate($rules);
		$validated['password'] = Hash::make($validated['password']);

		$user = User::create($validated);

		if ($user) {
			return redirect('/admin/users');
		} else {
			echo "Error!"; // TODO: Handle this.
		}
	}

	public function edit(User $user)
	{
		return view('admin.users.modify', ['is_edit_mode' => true, 'user' => $user]);
	}

	public function update(User $user, Request $request)
	{
		$rules = User::$validations;

		// Skip name validation if it has not changed
		if ($request->name === $user->name) {
			unset($rules['name']);
		}

		// Skip password validation if new one isn't provided
		if (empty($request->password) && empty($request->password_confirmation)) {
			unset($rules['password']);
		} else {
			// Enforce confirmation if new password provided
			$rules['password'] .= '|confirmed';
		}

		$validated = $request->validate($rules);

		if (key_exists('password', $validated)) {
			$validated['password'] = Hash::make($validated['password']);
		}

		if ($user->update($validated)) {
			return redirect('/admin/users');
		} else {
			echo "Error!"; // TODO: Handle this.
		}
	}
}
