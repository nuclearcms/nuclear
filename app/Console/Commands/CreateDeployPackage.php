<?php

namespace Reactor\Console\Commands;


use Illuminate\Console\Command;
use Reactor\Support\Packing\PackingService;

class CreateDeployPackage extends Command {

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
    protected $description = 'Creates a deploy package for the production environment.';

    /** @var PackingService */
    protected $packager;

    /**
     * Create a new command instance.
     *
     * @param PackingService $packager
     * @return void
     */
    public function __construct(PackingService $packager)
    {
        $this->packager = $packager;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Before creating the deploy package it is suggested that you compile production assets by running the "gulp --production" command.');

        if ($this->confirm('Do you wish to continue? [y|N]'))
        {
            $this->warn('Optimizing app...');
            $this->call('optimize', ['--force' => true]);

            $this->warn('Caching routes...');
            $this->call('route:cache');

            $this->comment('Creating the deploy package...');
            $this->packager->createDeployPackage();

            $this->info('Created the deploy package in the "backups directory.' . PHP_EOL);
        }
    }
}
