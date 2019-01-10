# About Live-Statics

Live-Statics is an open source Laravel package that helps developers providing them with a quick way to implement static pages, facilitating data injection into real views, in a way that all behaviors will be the same as the real ones. You won't have to spend any time with integration tasks any more.

Given that your statics and live views will be all the same, you will be allowed you to switch between them at any time, modifying things once for both of them.
Generated url's will behave as the real ones, providing you with a fully functional 'live-static' version of your web application that you can navigate clicking around.

You will be able to parametrize almost any generated content, so your statics can be changed in real time to modify how your site looks, which version of the fake data is injected and how shuld it be shown. This will come incredibly handy to perform visual QA, client presentations, and simply just to have a glance on how your site will behave with dynamic content.

Here's a [link to the full article](https://todo.com) with detailed explanations and live examples. Please give it a read!


# Install

1. Include the package

You can run the command:

```bash
composer require petrelli/live-statics
```

Or directly add it to your composer.json

```json
"petrelli/live-statics": "^0.0.1"
```

And run `composer update`.


2. Publish configuration files and the Service Provider

```
php artisan vendor:publish --provider="Petrelli\LiveStatics\BaseServiceProvider"
```


# Usage

Please give it a read to [the full article](https://todo.com) to understand better how the internals work. This package is more about concepts than advanced technicalities.


## Create a new mocked class, and it's interface


1. Run the command:

```bash
php artisan live-statics:class Book
```

This will use the configuration values inside `config/live-statics.php` to generate a base mocked class `Book`, plus an interface `BookInterface` that will allow you to bind it properly.

2. Add binding instructions to `config/live-statics.php`

```php
'mocked_classes' => [
    \App\Interfaces\BookInterface::class => [
        \App\Mocks\BookMock::class, \App\Book::class
    ],
],
```

The convention is the following:

```
'mocked_classes' => [
    INTERFACE1 => [ MOCKED_CLASS1, REAL_CLASS1 ],
    INTERFACE2 => [ MOCKED_CLASS2, REAL_CLASS2 ],
    ...
    INTERFACEn => [ MOCKED_CLASSn, REAL_CLASSn ],
]
```

This will be enough to use your interfaces to inject them properly!


3. Make your 'Real classes' implement the newly created interface


For example:

```php
use App\Interfaces\BookInterface;

class Book extends Model implements BookInterface
{
    #...
}
```

## Create a new mocked eloquent model

This is a special case of a general class. The package will provide a quick way for you to bind models as most systems will mock mainly them.


1. Generate the mocked model

```bash
php artisan live-statics:model Book
```

2. Add binding instructions to `config/live-statics.php`

```php
'mocked_models' => [
    'Book',
]
```

Here is the main difference with a regular class, the package will use the path configuration for models provided on `config/live-statics.php` to find and bind them properly.

3. Make your 'Real eloquent model' implement the newly created interface


## Add a custom namespace when creating new mocked classes or models

Keep your code organized creating namespaces for your mocked elements. Folders will be generated automatically.

This can be easily done passing by a second parameter to both commands:

```bash
# Prepend Api to the new class namespace
php artisan live-statics:class Book Api

# Prepend Api\Version1 to the new class namespace
php artisan live-statics:class Book Api\\Version1 #or
php artisan live-statics:class Book Api/Version1

# Prepend Api to the new model namespace
php artisan live-statics:model Book Api

# Prepend Api\Version1 to the new model namespace
php artisan live-statics:model Book Api\\Version1 #or
php artisan live-statics:model Book Api/Version1
```

When creating models, the namespace specified within `config/live-statics.php` will be added automatically.


## Using your newly created mocked elements

Let's use controllers as an example:

```php
use \App\Interfaces\BookInterface;


class Controller extends BaseController
{
    public function index(BookInterface $model)
    {
        # Use your Book instance as normal
        # $model->all();
        # $model->published()->get();
    }
}

```

If you are not confortable injecting as a formal parameter you can use the `app` function provided by laravel:

```php
use \App\Interfaces\BookInterface;


class Controller extends BaseController
{
    public function index()
    {
        $model = app(BookInterface:class);

        # Use your Book instance as normal
        # $model->all();
        # $model->published()->get();
    }
}

```


Once you are using interfaces to determine which instance (real or fake) your site shall use, then just proceed to enable/disable live-statics with your configured subdomain (By default 'static').

For example:

```bash

# Real site
# live.com

# Live statics site
# static.live.com

```

That's it!

You can change this subdomain modifying the `subdomain` option inside `config/live-statics.php`.


# Extra functionalities

TODO

## Namespaces and directories configuration

## Extending Faker through providers

## Creating different versions of your mocked classes

## Modifying your statics in real time through URL parameters

## Partial mocking



# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
