<?php

namespace App;

class Debug
{
	public static function logFormat(string $message, ...$args)
	{
		$message = sprintf($message, ...$args);
		echo sprintf($message, ...$args) . "\n";
	}

	public static function log($obj)
	{
		print_r($obj);
		echo "\n";
	}
}
