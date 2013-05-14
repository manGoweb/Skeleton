<?php

require __DIR__ . '/shortcuts.php';
use Nette\Diagnostics\Debugger;

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode(TRUE);
$configurator->enableDebugger(Debugger::DETECT, __DIR__ . '/../log', 'error@example.cz');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../vendor/others')
	->addDirectory(__DIR__ . '/../vendor/clevispace')
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

$container->application->catchExceptions = Debugger::$productionMode;

return $container;
