<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/exceptions.php';
require __DIR__ . '/config/Configurator.php';

umask(0);
return (new \App\Config\Configurator())->createContainer();
