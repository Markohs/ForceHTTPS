# ForceHTTPS

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![StyleCI][ico-styleci]][link-styleci]
[![](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://opensource.org/licenses/MIT)

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
...
```

### Set active environments

This package will only be active in the environments you specify, by default `stage`, `prod` and `production`, update `config/forcehttps.php` if necessary:

```php
    'envs_enabled' => ['stage', 'prod', 'production'],
```

### URL whitelist mechanism

This package also has a path exclusion mechanism I found useful in my projects. Even if a request is affected by this Middleware, a list of paths is checked, in a "whitelist" spirit, those URLS won't emit a 301 HTTP redirect. I use for comunitaction with other traditional systems that use old POST fashion, and don't support HTTPS.

You can set this url whitelist in  `config/forcehttps.php`:
```php
    'whitelist_url' => [
        'example/url',
        'example2'
    ],

```

## Important notes

If you are using Cloudflare or some kind of proxy to serve your website, you need to make sure you configure TrustedProxy correctly *or this Middleware will cause redirect loops*.

Make sure you keep the config file `/config/trustedproxy.php`, or on `app\Http\Middleware\TrustProxies.php` , variable `$proxies`, up to date. Or 

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, or want to help improve this package, please email marcos@tyrellcorporation.es or use the issue tracker or send a PR.

## Credits

- [Markohs][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/markohs/forcehttps.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/markohs/forcehttps.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/markohs/forcehttps/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/237038709/shield

[link-packagist]: https://packagist.org/packages/markohs/forcehttps
[link-downloads]: https://packagist.org/packages/markohs/forcehttps
[link-styleci]: https://styleci.io/repos/237038709
[link-author]: https://github.com/markohs
[link-contributors]: ../../contributors
