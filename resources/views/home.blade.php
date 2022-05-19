@extends('layouts.app')

@section('content')
<nav-bar></nav-bar>
<main>
    <router-view :key="$route.fullPath"></router-view>
</main>
@endsection
