<?php

namespace Reactor\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Factory;

class CreateExtension extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reactor:extension {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the scaffolds for a new extension.';

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

        $this->warn('Creating scaffolds for extension: ' . $name);

        $this->warn('Creating directory...');
        $filesystem->disk('reactorbase')->makeDirectory('extension/' . $name . '/Providers');

        $this->warn('Creating the service provider...');
        $this->createProvider($filesystem, $name);

        $this->info('Scaffolds are created.');
        $this->warn('Do not forget to add the service provider to the end of the providers array in config/app.');
    }

    /**
     * Create the service provider
     *
     * @param Factory $filesystem
     * @param string $name
     */
    protected function createProvider(Factory $filesystem, $name)
    {
        $stub = $filesystem->disk('reactorbase')->get('app/Support/stubs/provider.stub');

        $stub = str_replace(
            'DummyNamespace',
            'Extension\\' . $name . '\\Providers',
            $stub
        );

        $stub = str_replace(
            'DummyClass',
            $name . 'ExtensionServiceProvider',
            $stub
        );

        $filesystem->disk('reactorbase')
            ->put('extension/' . $name . '/Providers/' . $name . 'ExtensionServiceProvider.php', $stub);
    }
}
