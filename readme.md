# ForceSSL

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Simple Laravel Middleware to force HTTPS usage on your clients, with a simple whitelist system. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require markohs/forcehttps
```

Publish the default config file:
```
$  php artisan vendor:publish --tag=forcehttps.config
```

You can now edit default settings in config/forcehttps.php

## Usage

You can use any of the following methods:

You can either force HTTPS in a single route in for example `routes/web.php`:
```php
Route::get('/','StaticPageController@getRoot')->middleware('forcehttps');

```

You can also use the automatic MiddlewareGroup register mechanism in `config/forcehttps.php`:
```php
	'autoregister' => ['web']
```

Or you can add the Middleware manually as usual in `app/Http/Kernel.php` in the MiddlewareGroups you require:

```php
...
'web' => [
    \App\Http\Middleware\EncryptCookies::class,
...
    \Markohs\ForceSSL\Middleware\ForceHTTPS::class,
...

    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
..
```

## URL whitelist mechanism

This package also has a path exclusion mechanism I found useful in my projects. Even if a request is affected by this Middleware, a list of paths is checked, in a "whitelist" spirit, those URLS won't emit a 301 HTTP redirect. I use for comunitaction with other traditional systems that use old POST fashion, and don't support HTTPS.

You can set this url whitelist in  `config/forcehttps.php`:
```php
	'exception_url' => [
        'example/url',
        'example2'
    ],

```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email marcos@tyrellcorporation.es instead of using the issue tracker.

## Credits

- [Markohs][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/markohs/forcehttps.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/markohs/forcehttps.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/markohs/forcehttps/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/markohs/forcehttps
[link-downloads]: https://packagist.org/packages/markohs/forcehttps
[link-travis]: https://travis-ci.org/markohs/forcehttps
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/markohs
[link-contributors]: ../../contributors
