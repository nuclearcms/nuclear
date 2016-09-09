<?php

namespace Reactor\Console\Commands;

use Illuminate\Console\Command;
use Reactor\Support\Packing\PackingService;

class CreateBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactor:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a backup of the website.';

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
        $this->comment('Creating the backup...' . PHP_EOL);

        $this->packager->createBackup();

        $this->info(trans('maintenance.created_backup') . PHP_EOL);
    }
}
