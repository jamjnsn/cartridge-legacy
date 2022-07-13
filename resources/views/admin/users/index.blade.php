@extends('layouts.admin')

@section('admin-content')
<div class="page-title">
    <h1 class="title">Users</h1>
</div>

<div class="page-content">
	<div class="page-controls">
		<div class="buttons">
			<a href="/admin/users/new" class="button">
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
                    Username
                </div>
                <div class="flex-table-heading">
                    Role
                </div>
                <div class="flex-table-heading table-controls">

                </div>
            </div>
        </div>

        <div class="flex-table-body">
            @foreach ($users as $user)
            <div class="flex-table-row">
                <div class="flex-table-cell is-smaller">
                    {{ $user->id }}
                </div>
                <div class="flex-table-cell">
                    {{ $user->name }}
                </div>
                <div class="flex-table-cell">
                    {{ $user->is_admin ? "Admin" : "User" }}
                </div>
                <div class="flex-table-cell table-controls">
                    <div class="buttons">
                        <a href="/admin/users/{{ $user->id }}">
                            <icon type="edit-2" />
                        </a>
                        <a href="/admin/users/{{ $user->id }}" class="is-danger">
                            <icon type="trash" />
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
