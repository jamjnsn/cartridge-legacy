@extends('layouts.admin')

@section('admin-content')
<div class="page-title">
    @if($is_edit_mode)
    <h1 class="title">Edit {{ $platform->name }}</h1>
    @else
    <h1 class="title">New Platform</h1>
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

    <form action="{{ $is_edit_mode ? route('platforms.update', $platform) : route('platforms.store') }}" method="POST">
        @csrf
		@method($is_edit_mode ? 'PATCH' : 'POST')

        <x-forms.text-input name="name" label="Name" value="{{ old('name') ?? $platform->name }}" />
		<x-forms.text-input name="slug" label="IGDB Slug" value="{{ old('slug') ?? $platform->slug }}" />
		<x-forms.text-input name="directory_name" label="Directory Name" value="{{ old('directory_name') ?? $platform->directory_name }}" />

        <div class="buttons">
            <button class="button">
                <icon type="save"></icon> Save
            </button>
            <a href="{{ route('platforms.index') }}" class="button is-link">Cancel</a>
        </div>
    </form>
</div>
@endsection
