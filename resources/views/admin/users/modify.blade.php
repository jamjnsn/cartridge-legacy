@extends('layouts.admin')

@section('admin-content')
<div class="page-title">
    @if($is_edit_mode)
    <h1 class="title">Edit {{ $user->name }}</h1>
    @else
    <h1 class="title">New User</h1>
    @endif
</div>

<div class="page-content">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ $is_edit_mode ? route('users.update', $user) : route('users.store') }}" method="POST">
        @csrf
		@method($is_edit_mode ? 'PATCH' : 'POST')

        <x-forms.text-input name="name" label="Username" value="{{ old('name') ?? $user->name }}" />
        <x-forms.text-input name="password" type="password" label="Password" />
        <x-forms.text-input name="password_confirmation" type="password" label="Password (Confirm)" />

		<x-forms.toggle-input name="is_admin" label="Admin" is_checked="{{ $user->is_admin ? true : false }}" is_disabled="{{ $user->id === 1 ? true : false }}" />

        <div class="buttons">
            <button class="button">
                <icon type="save"></icon> Save
            </button>
            <a href="{{ route('users.index') }}" class="button is-link">Cancel</a>
        </div>
    </form>
</div>
@endsection
