<?php

require_once __DIR__ . '/boot.php';

//date_default_timezone_set('Europe/Prague');

$http = new HttpPHPUnit(NULL, FALSE);
$http->coverage(__DIR__ . '/../app', __DIR__ . '/coverage');
$http->run(__DIR__ . '/cases');
