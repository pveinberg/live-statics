<?php

namespace Petrelli\LiveStatics\Tests\Extras\Mocks;

use Petrelli\LiveStatics\Tests\Extras\Interfaces\BookInterface;
use Petrelli\LiveStatics\BaseMock;


class BookMock extends BaseMock implements BookInterface
{


	public static $baseInterface = BookInterface::class;


	// Mostly used to ignore eloquent scopes
	protected $returnSelfMethods = [
        'published'
    ];


	public static function define(&$mock)
	{

		// Attributes
		$mock->id          = 100;
		$mock->title       = 'Mocked Book';
		$mock->slug        = str_slug($mock->title);

	}


}
