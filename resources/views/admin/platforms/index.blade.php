@extends('layouts.admin')

@section('admin-content')
<div class="page-title">
    <h1 class="title">Platforms</h1>
</div>

<div class="page-content">
	<div class="page-controls">
		<div class="buttons">
			<a href="{{ route('platforms.create') }}" class="button">
				<icon type="user-plus"></icon> <span>New</span>
			</a>
		</div>
	</div>

    <div class="flex-table">
        <div class="flex-table-header">
            <div class="flex-table-row">
                <div class="flex-table-heading is-smaller">
                    ID
                </div>
                <div class="flex-table-heading">
                    Name
                </div>
                <div class="flex-table-heading">
                    IGDB Slug
                </div>
                <div class="flex-table-heading">
                    Directory
                </div>
                <div class="flex-table-heading table-controls">

                </div>
            </div>
        </div>

        <div class="flex-table-body">
            @foreach ($platforms as $platform)
            <div class="flex-table-row">
                <div class="flex-table-cell is-smaller">
                    {{ $platform->id }}
                </div>
                <div class="flex-table-cell">
                    {{ $platform->name }}
                </div>
                <div class="flex-table-cell">
                    {{ $platform->slug }}
                </div>
                <div class="flex-table-cell">
                    /{{ $platform->directory_name }}
                </div>
                <div class="flex-table-cell table-controls">
					<a href="{{ route('platforms.edit', $platform) }}" class="button is-small">
						<icon type="edit-2" />
					</a>

					<form action="{{ route('platforms.destroy', $platform) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $platform->name }}?');">
						@csrf
						@method('DELETE')
						<button class="button is-small is-danger" type="submit"><icon type="trash" /></button>
					</form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
