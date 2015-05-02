# I LOVE PUGS!
A simple PHP wrapper around [http://pugme.herokuapp.com](http://pugme.herokuapp.com)

### Usage:

```
    composer require olyckne/pug
``` 

#### Standard php:

```php
$pug = new Olyckne\Pug\Pug;
$pug->random(); // returns link to an image
$pug->bomb($count=5) // returns an array of links to images
```


#### Laravel:
```
// app/config/app.php

'providers' => [
    '...',
    'Olyckne\Pug\PugServiceProvider'
];

'facades' => [
    '…',
    'Olyckne\Pug\PugFacade'
];
```

Then you can use the nice facade

```
    Route::get('/', function () {
        $pug = Pug::random();
        return View::make('index', compact('pug'));
    });
```

#### Lumen:

```
    // boostrap/app.php
    // uncomment $app->withFacades();
    // register the service provider ddsand facade
    $app->register('Olyckne\Pug\PugServiceProvider');
    class_alias('Olyckne\Pug\PugFacade', 'Pug');
```