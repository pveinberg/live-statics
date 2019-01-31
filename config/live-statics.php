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
    | Base Namespace
    |--------------------------------------------------------------------------
    |
    | Added as a simple way to change the way to bind models. You usually won't
    | need to modify this
    |
    */

    'base_namespace'  => 'App',



    /*
    |--------------------------------------------------------------------------
    | Faker extra providers
    |--------------------------------------------------------------------------
    |
    | To generate better content for your site you can specify faker providers
    | classes here and they will be added automatically when creating the
    | singleton instance.
    |
    | Here as a working example, you can use a new image provider
    | to generate Picsum URL's instead of the default Lorempixel ones
    |
    */

    'faker_providers' => [
        // \Petrelli\LiveStatics\Providers\FakerImagePicsumProvider::class,
    ],



];
