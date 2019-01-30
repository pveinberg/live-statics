<?php

namespace Tests;

use Mockery;
use Petrelli\LiveStatics\BaseServiceProvider;
use Petrelli\LiveStatics\Tests\Extras\Interfaces\BookInterface;
use Petrelli\LiveStatics\Tests\Extras\Mocks\BookMock;
use Petrelli\LiveStatics\Tests\Extras\Book;

class BaseServiceProviderMockTest extends \Orchestra\Testbench\TestCase
{

    protected $baseUrl = 'http://static.localhost';


    protected function getPackageProviders($app)
    {

        return [
            BaseServiceProvider::class,
        ];

    }


    /**
     * Overwrite config elements here to have them available before
     * the Service Providers calls `register`
     */
    protected function resolveApplicationConfiguration($app)
    {

        parent::resolveApplicationConfiguration($app);

        $app['config']->set('app.url', 'http://static.localhost.com');

        $app['config']->set('live-statics', [
            'subdomain'       => 'static',
            'base_namespace'  => 'Petrelli\\LiveStatics\\Tests\\Extras',
            'path_interfaces' => 'Interfaces',
            'path_models'     => '',
            'path_mocks'      => 'Mocks',
            'mocked_classes'  => [ BookInterface::class => [BookMock::class, Book::class]],
            'mocked_models'   => [],
            'faker_providers' => [
                // \Petrelli\LiveStatics\Providers\FakerImagePicsumProvider::class,
            ]
        ]);

    }


    public function testClassBinding()
    {

        $object = app(BookInterface::class);

        $this->assertInstanceOf(BookMock::class, $object);
        $this->assertEquals($object->title, 'Mocked Book');

    }


}
