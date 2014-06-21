<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/config/Configurator.php';

return (new \App\Config\Configurator())->createContainer();
