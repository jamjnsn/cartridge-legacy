@extends('layouts.app')

@section('content')
<div id="admin-panel">
    <div id="menu">
        <div class="logo">
            <a href="/">
                <img src="{{ mix("images/logo-full.png") }}" />
            </a>
        </div>

        <a href="/admin" class="button is-full-width">
            <icon type="home"></icon> <span>Dashboard</span>
        </a>

        <a href="/admin/users" class="button is-full-width">
            <icon type="user"></icon> <span>Users</span>
        </a>

        <a href="/admin/platforms" class="button is-full-width">
            <icon type="book"></icon> <span>Platforms</span>
        </a>

        <a href="/admin/settings" class="button is-full-width">
            <icon type="settings"></icon> <span>Settings</span>
        </a>

        <form ref="logout" action="/logout" method="POST" class="menu-item">
            @csrf
            <button class="button is-full-width">
                <icon type="log-out"></icon> <span>Logout</span>
            </button>
        </form>
    </div>

    <main>
        @yield('admin-content')
    </main>

    @php
    $status = session()->get('status');
    @endphp

    @if($status)
    <div class="flashes">
        <div class="alert is-{{ $status['type'] }}">
            <p>{{ $status['message'] }}</p>
        </div>
    </div>
    @endif
</div>

@endsection
