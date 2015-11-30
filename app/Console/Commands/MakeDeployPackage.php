<?php

namespace Reactor\Console\Commands;


use Illuminate\Config\Repository;
use Illuminate\Console\Command;

class MakeDeployPackage extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactor:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a deploy package for production.';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating the deploy package...');
        $this->line('');

        $this->warn('You should run "gulp --production --r" before running this command...');

        if ($this->confirm('Would you like to continue?', true))
        {
            $this->warn('Optimizing app...');
            $this->call('optimize');

            $this->warn('Caching routes...');
            $this->call('route:cache');

            $this->warn('Creating ZIP backup...');
            $this->createPackage();

            $this->info('Completed creating the deploy package.');
            $this->warn('The package is stored in the backups directory.');
        } else
        {
            $this->error('Aborted');
        }
    }

    protected function createPackage()
    {
        // Set the config in order to include vendor directory as well
        $included = config('laravel-backup.source.files.include');
        $included[] = base_path('vendor');
        config()->set('laravel-backup.source.files.include', $included);

        // Run the backup
        $this->call('backup:run');
    }
}
