<?php

namespace Petrelli\LiveStatics\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;


class CreateMockedClass extends Command
{

    protected $signature = 'live-statics:class {name} {extraNamespace?}';

    protected $description = 'Create a new Mocked Class';

    protected $files;

    protected $composer;


    public function __construct(Filesystem $files, Composer $composer)
    {

        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;

    }


    public function handle()
    {

        $name = $this->argument('name');
        $namespace = $this->argument('extraNamespace');

        $className = Str::studly(Str::singular($name));

        $this->createStatic($className, $namespace);

        $this->composer->dumpAutoloads();

    }


    protected function processNamespaces($namespaces)
    {

        return array_filter(preg_split('/\\\\|\//', $namespaces));

    }


    protected function createStatic($className, $extraNamespace = null)
    {

        /**
         * Process extra namespaces and transform into an array
         */
        if (!is_array($extraNamespace)) {
            $extraNamespace = $this->processNamespaces($extraNamespace);
        }


        /**
         * Create mocks directory
         */
        $absoluteMocksDirectory = app_path(join('/', array_filter([config('live-statics.path_mocks'), join('/', $extraNamespace)])));

        if (!$this->files->isDirectory($absoluteMocksDirectory)) {
            $this->files->makeDirectory($absoluteMocksDirectory, 0777, true);
        }


        /**
         * Create mocks directories for interfaces
         */
        $absoluteInterfacesDirectory = app_path(config('live-statics.path_interfaces'));
        $absoluteInterfacesDirectory = app_path(join('/', [config('live-statics.path_interfaces'), join('/', $extraNamespace)]));
        if (!$this->files->isDirectory($absoluteInterfacesDirectory)) {
            $this->files->makeDirectory($absoluteInterfacesDirectory, 0777, true);
        }


        $classPath = join('\\', array_filter([config('live-statics.path_mocks'), join('\\', $extraNamespace)]));
        $interfacesPath = join('\\', array_filter([config('live-statics.path_interfaces'), join('\\', $extraNamespace)]));

        /**
         * Fill up the template with the new class to be created
         */
        $stub = str_replace(
            ['{{className}}', '{{classPath}}', '{{interfacesPath}}'],
            [$className, $classPath, $interfacesPath],
            $this->files->get(__DIR__ . '/stubs/mockedClass.stub')
        );

        /**
         * Fill up the template with the new interface to be created
         */
        $interfaceStub = str_replace(
            ['{{className}}', '{{interfacesPath}}'],
            [$className, $interfacesPath],
            $this->files->get(__DIR__ . '/stubs/mockedInterface.stub')
        );

        /**
         * Place the files where they belong within your application
         */
        $mockAbsoluteFile      = join('/', [$absoluteMocksDirectory, $className . 'Mock.php']);
        $interfaceAbsoluteFile = join('/', [$absoluteInterfacesDirectory, $className . 'Interface.php']);

        $this->files->put($mockAbsoluteFile, $stub);
        $this->files->put($interfaceAbsoluteFile, $interfaceStub);

        /**
         * Finito
         */
        $mockClass = join('\\', ['\App', $classPath, $className . 'Mock']);
        $interfaceClass = join('\\', ['\App', $interfacesPath, $className . 'Interface']);

        $this->printFinalMessage($className, $mockAbsoluteFile, $mockClass, $interfaceClass);

    }


    protected function printFinalMessage($className, $mockAbsoluteFile, $mockClass = null, $interfaceClass = null)
    {

        $this->info("\nThe Mocked class {$className} has been created successfully!");
        $this->line("To edit please go to {$mockAbsoluteFile}");
        $this->line("Now to BIND them open `config/live-statics.php` and add to the 'mocked_classes' array the following element:");
        $this->info("{$interfaceClass}::class => [{$mockClass}::class, 'YOUR_REAL_CLASS']\n\n");

    }


}
