<?php

namespace Reactor\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Contracts\Filesystem\Filesystem;

class CreateTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactor:theme {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the scaffolds for a new theme.';

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
     * @param Factory $filesystem
     * @return mixed
     */
    public function handle(Factory $filesystem)
    {
        $name = $this->argument('name');

        $this->warn('Creating scaffolds for theme: ' . $name);

        $this->warn('Creating public directories...');
        $filesystem->disk('reactorbase')->makeDirectory('public/' . $name . '_assets/img');
        $filesystem->disk('reactorbase')->makeDirectory('public/' . $name . '_assets/js');
        $filesystem->disk('reactorbase')->makeDirectory('public/' . $name . '_assets/css');

        $this->warn('Creating resources directories...');
        $filesystem->disk('reactorbase')->makeDirectory('resources/assets/' . $name . '/js');
        $filesystem->disk('reactorbase')->makeDirectory('resources/assets/' . $name . '/sass');
        $filesystem->disk('reactorbase')->makeDirectory('resources/views/' . $name);

        $this->warn('Creating routes file...');
        $filesystem->disk('reactorbase')->put('routes/' . $name . '.php', '<?php' . PHP_EOL);

        $this->info('Scaffolds are created.');
        $this->warn('Do not forget to add the theme in config/themes and gulpfile.');
    }
}
