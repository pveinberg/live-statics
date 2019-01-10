<?php

namespace Petrelli\LiveStatics\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;


class CreateMockedModel extends CreateMockedClass
{


    protected $signature = 'live-statics:model {name} {extraNamespace?}';

    protected $description = 'Create a new Mocked Class connected to a Laravel Model';


    protected function createStatic($className, $extraNamespace = null)
    {

        /**
         * Process extra namespaces and transform into an array
         */
        $modelsNamespaces = $this->processNamespaces(config('live-statics.path_models'));
        $extraNamespace   = array_merge($modelsNamespaces, $this->processNamespaces($extraNamespace));

        parent::createStatic($className, $extraNamespace);

    }


    protected function printFinalMessage($className, $mockAbsoluteFile, $mockClass = null, $interfaceClass = null)
    {

        $this->info("\nThe Mocked model {$className} has been created successfully!");
        $this->line("To edit please go to {$mockAbsoluteFile}");
        $this->info("Now add '{$className}' to the \$mocked_models array inside `config/live-statics.php` to bind them properly\n");

    }


}
