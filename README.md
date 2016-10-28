# Multi language Laravel Plugin

This package pulls in the framework agnostic Language Manager and provides seamless integration with **Laravel 5**.

- [What is it?](#what-is-it?)
- [Installation](#installation)
- [Usage](#usage)
- [Requirements](#requirements)
- [License](#license)

## What is it?

Language manager: you can choose new language and it will be placed as `App::setLocale($lang)`

Language will be saved in SESSION and/or COOKIE

Also you can use URL
```
http://www.example.com/article/1?lang=en => http://en.example.com/en/article/1 
```

## Installation

`composer require zagovorichev/laravel-languages`

Add to the **app.php** (by default in */laravel/config/app.php*) lines:

```php
'providers' => [
    // ...
    Zagovorichev\Laravel\Languages\LanguageServiceProvider::class,
]
```

And new middleware into the **Kernel.php** (look in */laravel/app/Http/Kernel.php*)

```php
protected $middlewareGroups = [
        'web' => [
            // ...
            \Zagovorichev\Laravel\Languages\Http\Middleware\LanguagesMiddleware\LanguagesMiddleware::class,
        ],
    ];
```

## Usage

Language manager provides working with sessions, cookies, path and domain.

For changing system language send request with input **lang**. For example: `?lang=es`
and in application you will have Spain locale.

All configurations stored in the **languages.php** file.  
For making your own configuration copy file */laravel/vendor/zagovorichev/laravel-languages/config/languages.php* 
to the folder */laravel/config/*.

#### Simple usage (SESSION + COOKIE)
If you need simple language manager you can use only 'session' and 'cookie' modes. Then you don't need to
configure anything more.

#### Domain Map

For using DomainMapManger in your configuration file you should matched languages and domains

```
'domainMap' => [
    'en' => 'www.example.com',
    'es' => 'es.example.com',
    'ua' => 'www.example.ua',
],
```

#### Domain 

Also you can provide regular expression in the configuration file.

```php
'domainRegExp' => [
    'reg' => '|^(http://)([a-z]{2})[\.]{0,1}(example\.com.*)$|ui',
    'langPart' => 2,
]
```

And as a result you will have
`http://www.example.en/post/234 => http://en.example.com/post/234 => http://es.example.com/post/234`

#### Path
Similar to domains, you can provide regular expression:

```php
'pathRegExp' => [
     'reg' => '|([a-z]{2})(/.*)|ui',
     'langPart' => 1, // lang part will be replaced with new lang
 ],
```


### Modes of the languages manager

Each store has its own manager.

- **session** - store in the $_SESSION  
- **cookie** - store in the browser $_COOKIES  
- **domain** - use domain name for determining current language (www.example.com, en.example.com, es.example.com...)  
- **path** - use uri for language example.com/en/address


## Requirements

* PHP 5.6
* Laravel 5.3

## License

This package is licensed under the [MIT license](https://github.com/backup-manager/laravel/blob/master/LICENSE)
