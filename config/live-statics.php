<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Subdomain acting as a switch
    |--------------------------------------------------------------------------
    |
    | Whenever this subdomain, or any versioned variations are present
    | live statics will be activated.
    |
    */

    'subdomain' => 'static',


    /*
    |--------------------------------------------------------------------------
    | Path configurations
    |--------------------------------------------------------------------------
    |
    | These variables will control your directory structure
    | Default values are usually ok for most projects
    |
    | Given that these values are used to bind elements and generate new mocks,
    | do not to modify them once the project has started.
    |
    | Laravel models don't use namespaces by default, added
    |
    */

    'path_interfaces' => 'Interfaces',
    'path_models'     => '',
    'path_mocks'      => 'Mocks',


    /*
    |--------------------------------------------------------------------------
    | Mocked Classes
    |--------------------------------------------------------------------------
    |
    | To mock specific classes you will need to add the interface name,
    | plus the full path to the desired mocked element, and the real class
    |
    | Format of each item is:
    |
    |     INTERFACE => [ MOCKED_CLASS, REAL_CLASS ]
    |
    |
    | Example:
    |
    | 'mocked_classes' => [
    |
    |   \App\Interfaces\ThemeInterface::class => [
    |       \App\Mocks\Models\Theme::class, \App\Models\Theme::class
    |   ],
    |   ...
    |
    | ]
    |
    |
    */

    'mocked_classes' => [
    ],


    /*
    |--------------------------------------------------------------------------
    | Mocked Models
    |--------------------------------------------------------------------------
    |
    | Helper to quickly bind mocked models.
    | It will use `path_models` to search for the mocked class,the real class,
    | and it's interface on their respective directories.
    |
    | 'mocked_models' => [
    |
    |   'Theme',
    |   'Book',
    |
    |   ...
    |
    | ]
    |
    */


    'mocked_models' => [
    ],


    /*
    |--------------------------------------------------------------------------
    | Faker extra providers
    |--------------------------------------------------------------------------
    |
    | To generate better content for your site you can specify faker provider
    | classes here and they will be added automatically when creating the
    | singleton instance.
    |
    | As the default example, you can overload the image generator to use Picsum.
    |
    */

   'faker_providers' => [
        // \Petrelli\LiveStatics\Providers\FakerImagePicsumProvider::class,
   ]


];