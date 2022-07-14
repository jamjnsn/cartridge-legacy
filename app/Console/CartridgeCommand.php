<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\LogLevel;

use App\Models\User;

class CartridgeCommand extends Command
{
	public function __construct()
	{
		parent::__construct();
	}

	// Wrapper command for debug logging;
	public function message($message, $log_level = LogLevel::Debug) {
		switch($log_level) {
			case LogLevel::Error:
				$style = "<fg=red>";
				break;
			case LogLevel::Warning:
				$style = "<fg=yellow>";
				break;
			default:
				$style = '';
				break;
		}

		$this->line($style.$message.'</>');
	}
}
