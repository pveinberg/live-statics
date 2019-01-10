<?php

namespace Petrelli\LiveStatics;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

// use \App\Mocks\Models\Traits\HasBlocks;
// use \App\Mocks\Models\Traits\HasImages;

class BaseMock implements Arrayable, UrlRoutable
{

    /**
     * IMPORTANT TRAITS: Used to define Twill functions to render blocks and images
     */
    // use HasImages, HasBlocks;

    public static $baseClass;
    public static $baseInterface;

    // Used to store the actual mocked object
    public $mockedObject;

    // Set 'slug' as the default attribute to build URL's
    protected $primaryKey = 'slug';

    // Appends these attribute/relations when serializing this object
    protected $appends = [];

    // Methods that should return $this
    // This is used mostly to mock the use of scopes
    protected $returnSelfMethods = [];

    public static function create()
    {

        // Create a mocked object
        // Pass the interface as the second argument (for dependency injection to work)

        if (static::$baseClass) {
            $mock = \Mockery::mock(static::$baseClass, static::$baseInterface)->makePartial();
        } else {
            $mock = \Mockery::mock(static::$baseInterface);
        }

        // Define base methods and attributes for the mocked model
        static::define($mock);

        // Return a new container object with an underline mocked instance.
        // This is done this way to provide a layer on top of the mocked object
        // so we can define there new functions and/or attributes
        // that we can use at execution time. This will solve the problem when we
        // instantiate the same object inside itself.
        return new static($mock);

    }

    public static function define(&$mock)
    {

        return $mock;

    }

    public function __construct($mock)
    {

        $this->mockedObject = $mock;

    }

    /**
     * ---------------------------------------------------------------------------------
     *
     *  The following functions are magic methods that allows a better definition of
     *  mocked attributes and functions.
     *  Basically, if the method or attribute doesn't exists locally,
     *  we bypass it to the mocked object
     *
     *  We also provide the Laravel functionality to define attributes using a function:
     *  function get[NAME]Attribute() will allow the [NAME] attribute at the object.
     *
     * ---------------------------------------------------------------------------------
     */

    /**
     * Dynamically handle calls into the mocked instance if not defined.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     */
    public function __call($method, $parameters)
    {

        if (method_exists($this, $method)) {
            return $this->$method(...$parameters);
        }

        if (in_array($method, $this->returnSelfMethods)) {
            return $this;
        }

        return $this->mockedObject->{$method}(...$parameters);

    }

    /**
     * Dynamically retrieve attributes. Defined here or at the mocked object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {

        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key);
        } else {
            return $this->$key ?? $this->mockedObject->$key;
        }

    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {

        return method_exists($this, 'get' . Str::studly($key) . 'Attribute');

    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function mutateAttribute($key)
    {

        return $this->{'get' . Str::studly($key) . 'Attribute'}();

    }

    /**
     *
     *  When transforming to array just use the mocked Object
     *  and then add all new local mutated attributes
     *  (get[NAME]Attribute() like function)
     *
     */
    public function toArray()
    {
        $object = $this->mockedObject;

        // Get all mutated attributes
        $attributes = static::listMutatedAttributes(get_class($this));

        // Add them to the base object
        foreach ($attributes as $name) {
            if (in_array($name, $this->appends)) {
                $object->$name = $this->$name;
            }
        }

        return $object;
    }

    /**
     *
     * Extract all mutated attributes names
     *
     */
    public static function listMutatedAttributes($class)
    {
        $mutatedAttributes = [];

        if (preg_match_all('/(?<=^|;)get([^;]+?)Attribute(;|$)/', implode(';', get_class_methods($class)), $matches)) {
            foreach ($matches[1] as $match) {
                $mutatedAttributes[] = lcfirst($match);
            }
        }

        return $mutatedAttributes;
    }

    /**
     *
     * UrlRoutable interface implementation
     * This is used to be passed into a route() and generate correct URL's
     *
     */

    public function getRouteKey()
    {

        $attributeName = $this->getRouteKeyName();

        return $this->$attributeName;

    }

    public function getRouteKeyName()
    {

        return $this->getKeyName();

    }

    public function getKeyName()
    {

        return $this->primaryKey;

    }

    public function resolveRouteBinding($value)
    {

        return $this;

    }


}
