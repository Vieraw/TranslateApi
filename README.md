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
        //We disable the verification of the SSL certificate used to work with the HTTP protocol.
        $gt = new GoogleTranslate(array('verifyPeer' => false));
        echo
        $gt->translate('Привет', 'en'), // or $gt->translate('Привет', 'en', 'ru')
        //Enable language autodetection for correct transliteration
        $gt->translit('Привет', 'en'); // or $gt->translate('Привет', 'en', 'ru')
    }
    catch (\Throwable $e)
    {
        echo $e->getMessage();
    }
```

## Use with proxy server

```php
<?php

    include_once 'vendor/autoload.php';

    use TranslateApi\GoogleTranslate;
    
    try
    {
        //We disable the verification of the SSL certificate used to work with the HTTP protocol.
        //Specify the data to connect to the proxy server
        $gt = new GoogleTranslate(
            array(
                'verifyPeer' => false, 
                'request_fulluri' => true, 
                'proxy' => '<host>:<port>',
                //
                'header' => ['Proxy-Authorization: <type> <credentials>'] // or 'header' => 'Proxy-Authorization: <type> <credentials>'
            )
        );
        echo
        $gt->translate('Привет', 'en'), // or $gt->translate('Привет', 'en', 'ru')
        //Enable language autodetection for correct transliteration
        $gt->translit('Привет', 'en'); // or $gt->translate('Привет', 'en', 'ru')
    }
    catch (\Throwable $e)
    {
        echo $e->getMessage();
    }
```

## Additional options

```
verifyPeer - Require verification of the SSL certificate used. The default is TRUE.
verifyPeerName - Require verification of the host name. The default is TRUE.
allowSelfSigned - Allow self-signed certificates. Requires verifyPeer. Default is FALSE;
proxy - Proxy server data;
request_fulluri - When set to TRUE, the entire URI will be used when generating the request. (For example, GET http://www.example.com/path/to/file.html HTTP / 1.0). Although this is a non-standard query format, some proxy servers require it. Default is FALSE.;
header - Additional headers for sending along with the request. The values in this option will override other values (such as User-agent :, Host: and Authentication :).
```