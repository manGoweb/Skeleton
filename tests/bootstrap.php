<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/exceptions.php';
require __DIR__ . '/../app/config/Configurator.php';

umask(0);

$config = new \App\Config\Configurator([
	'testMode' => TRUE,
]);
$container = $config->createContainer();
Tester\Environment::setup();
return $container;

function runTests()
{
	call_user_func_array([Tests\Helper::class, 'runTests'], func_get_args());
}
