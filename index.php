<?php
/**
 * Created by PhpStorm.
 * User: Vieraw
 * Date: 26.04.2018
 * Time: 18:01
 */

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
