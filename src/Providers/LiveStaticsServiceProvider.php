<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class LiveStaticsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        /**
         * This is how we extend faker with more providers
         */

        // $this->app->extend('faker', function ($faker) {
        //     $entity = FakerWordsProvider::class;
        //     $faker->addProvider(new $entity($faker));
        //     return $faker;
        // });



        /**
         * This is how we bind an interface with a live-static switch
         */

        // $this->app->bind(\App\Interfaces\ThemeInterface::class, function () {
        //     if (config('live-statics.enabled')) {
        //         return \App\Mocks\Models\ThemeMock::create();
        //     } else {
        //         return app(\App\Models\Theme::class);
        //     }
        // });



        /**
         * This is how we bind an interface with a live-static switch plus versioning
         */

        // $this->app->bind(\App\Interfaces\ThemeInterface::class, function () {
        //     if (config('live-statics.enabled')) {
        //         $entity = \App\Mocks\Models\ThemeMock::class;
        //         if (config('live-statics.version')) {
        //             $versionedEntity = $entity . config('live-statics.version');
        //             if (class_exists($versionedEntity)) {
        //                 $entity = $versionedEntity;
        //             }
        //         }
        //         return $entity::create();
        //     } else {
        //         return app(\App\Models\Theme::class);
        //     }
        // });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


    }


}

