# TranslateApi

## Installation
Install the latest version with. \
In the composer.json add sections:
```bash
    "repositories":
    [
        {
            "type": "git",
            "url": "https://github.com/Vieraw/TranslateApi.git"
        }
    ],
    "require":
    {
        "Vieraw/TranslateApi": "dev-master"
    },
```

Execute:
```bash
$ composer install
```


## Basic Usage

```php
<?php

    include_once 'vendor/autoload.php';

    use TranslateApi\GoogleTranslate;
    
    try
    {
        $gt = new GoogleTranslate(array('verifyPeer' => false));
        echo
        $gt->translate('en', 'en', 'Привет'),
        $gt->translit('en', 'en', 'Привет');
    }
    catch (\Throwable $e)
    {
        echo $e->getMessage();
    }
```
