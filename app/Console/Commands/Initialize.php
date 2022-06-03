<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

class Initialize extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cart:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Ensure required initialization is completed.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		// Ensure app key is present
		if (!ENV("APP_KEY")) {
			echo "🔑 Generating app key...\n";

			// Add APP_KEY key. Needed for generation.
			file_put_contents(base_path() . '/.env', "\nAPP_KEY=\n", FILE_APPEND | LOCK_EX);

			Artisan::call('key:generate');
			echo Artisan::output();
			echo "\n";
		}

		echo "📦 Linking storage...\n";
		Artisan::call('storage:link');
		echo Artisan::output();

		echo "💿 Running database migrations...\n";
		Artisan::call('migrate');
		echo Artisan::output();

		// Seed database if no users exist
		if(User::count() === 0) {
			echo "👤 Creating admin account...\n";
			Artisan::call('db:seed');
			echo Artisan::output();
		}

		return 0;
	}
}
