# About Live-Statics

[![Build Status](https://travis-ci.org/ferpetrelli/live-statics.svg?branch=master)](https://travis-ci.org/ferpetrelli/live-statics)

Live-Statics is an open source Laravel package that will help you quickly build prototypes and static pages facilitating data injection into real views. Because all mocked objects will behave as the real ones you won't have to spend any time with integration tasks.

Both real and mocked data sources will live together so you will be able you to switch between them at any time. Also because our fake objects will behave as real, a fully functional 'live-static' version of your web application will be accessible to explore and click around.

Almost any generated content can be parametrized, so your live-statics can be modified in real time by just passing some URL parameters. This will come incredibly handy to perform visual QA, client presentations, and simply just to have a glance on how your site will behave with dynamic content.

# Custom Install

1. Criar uma máquina no docker com as configurações requeridas, incluíndo o composer, a versão certa do laravel, etc;
2. Rodar a aplicação; 
3. Configurar o banco mysql com a base do redmine para testes; 
4. Implementar as alterações na aplicação para visualizar as estatísticas;
5. Configurar servidor docker com as configurações necessárias para rodar essa aplicação; 
6. Rodar e testar;


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

## Create a new mocked Eloquent model

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

3. Make your 'Real Eloquent model' implement the newly created interface


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

If you are not confortable injecting dependencies as formal parameters you can use the `app` function provided by laravel:

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


Once interfaces are being used to determine which instance (real or fake) your site shall use, you can just proceed to enable/disable live-statics by adding your configured subdomain (By default 'static').

For example:

```bash

# Real site
live.com

# Live statics site
static.live.com

```

That's it!

You can change this subdomain modifying the `subdomain` option inside `config/live-statics.php`.


# Extra functionalities

Docs to be completed.

## Namespaces and directories configuration

Docs to be completed.

## Extending Faker through providers

Docs to be completed.

## Creating different versions of your mocked classes

Docs to be completed.

## Modifying your statics in real time through URL parameters

Docs to be completed.

## Partial mocking

Docs to be completed.


# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
