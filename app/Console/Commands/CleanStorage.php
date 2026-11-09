<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;

class CleanStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean all files from the storage/app/public directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!App::environment('local', 'development')) {
            $this->error('This command can only be run in the development environment.');
            return;
        }

        $directory = storage_path('app/public');

        // Check if the directory exists
        if (!File::exists($directory)) {
            $this->error("The directory {$directory} does not exist.");
            return;
        }

        // Get all files in the directory
        $files = File::allFiles($directory);

        if (count($files) === 0) {
            $this->info("The directory {$directory} is already empty.");
            return;
        }

        // Delete all files
        File::delete($files);

        $this->info("All files in {$directory} have been deleted.");
    }
}
