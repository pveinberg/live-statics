<?php

namespace Tests;

use Petrelli\LiveStatics\BaseServiceProvider;
use Petrelli\LiveStatics\Tests\Extras\Interfaces\BookInterface;
use Petrelli\LiveStatics\Tests\Extras\Interfaces\VideoInterface;
use Petrelli\LiveStatics\Tests\Extras\Mocks\BookMock;
use Petrelli\LiveStatics\Tests\Extras\Mocks\VideoMock;
use Mockery;

class BaseMockTest extends \Orchestra\Testbench\TestCase
{

    protected $book, $video;

    protected function setUp()
    {

        parent::setUp();

        $this->book  = app(BookInterface::class);
        $this->video = app(VideoInterface::class);

    }

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
            'mocked_classes'  => [
                BookInterface::class  => [BookMock::class, Book::class],
                VideoInterface::class => [VideoMock::class, null]
            ],
            'mocked_models'   => [],
            'faker_providers' => [
                // \Petrelli\LiveStatics\Providers\FakerImagePicsumProvider::class,
            ]
        ]);

    }


    protected function getPackageAliases($app)
    {

        return [
            'Route' => \Illuminate\Support\Facades\Route::class,
        ];

    }


    public function testInstanceImplementation()
    {

        $this->assertInstanceOf(BookMock::class, $this->book);

    }


    public function testReturnSelfMethods()
    {

        $this->assertEquals($this->book->published(), $this->book);

    }


    public function testDefinedAttributes()
    {

        $this->assertEquals($this->book->id, 100);
        $this->assertEquals($this->book->title, 'Mocked Book');
        $this->assertEquals($this->book->slug, 'mocked-book');

    }


    public function testPrimaryKeyRouteHelper()
    {

        \Route::get('test/{slug}')->name('test');

        // Book has 'slug' as primary key
        $this->assertEquals('http://static.localhost.com/test/mocked-book', route('test', $this->book));

        // Video has 'id' as primary key
        $this->assertEquals('http://static.localhost.com/test/100', route('test', $this->video));

    }


    public function testUndefinedParameter()
    {

        $this->expectExceptionMessage('Undefined property');
        $this->book->url;

    }


    public function testDefinedParameterInMockedObject()
    {

        $this->assertNotNull($this->video->url);
        $this->assertEquals($this->video->url, 'http://youtube.com');

    }


    public function testDefinedParameterInMutator()
    {

        $this->assertNotNull($this->video->urlMutator);
        $this->assertEquals($this->video->urlMutator, 'http://youtube.com/mutator');

    }


}
