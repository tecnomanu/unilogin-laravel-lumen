<?php

namespace Tecnomanu\UniLogin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CopyViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unilogin:copy-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy UniLogin views to the main application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sourcePath = __DIR__.'/../views';
        $destinationPath = base_path('resources/views/vendor/unilogin');

        if (File::isDirectory($destinationPath)) {
            if ($this->confirm('Views already exist in your application. Do you wish to overwrite them?')) {
                File::deleteDirectory($destinationPath);
            } else {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        File::copyDirectory($sourcePath, $destinationPath);

        $this->info('UniLogin views copied successfully.');

        return 0;
    }
}
