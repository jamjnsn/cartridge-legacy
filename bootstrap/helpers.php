<?php

function app_url($path = '') {
	$protocol = env('APP_PROTOCOL', 'http');
	$host = env('APP_HOST', 'localhost');
	$port = env('APP_PORT', '80');
	return "$protocol://$host:$port$path";
}