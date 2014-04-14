<?php

namespace Tests;

use Nette;
use Nette\Diagnostics\Debugger;
use Orm;

define('TESTS_DIR', __DIR__);
define('APP_DIR', __DIR__ . '/../app');
define('LIBS_DIR', __DIR__ . '/../vendor');
define('TEMP_DIR', __DIR__ . '/../temp');

require_once LIBS_DIR . '/autoload.php';
require_once APP_DIR . '/config/Configurator.php';
require_once TESTS_DIR . '/inc/TestsConfigurator.php';

// Configure application
$configurator = new TestsConfigurator(__DIR__ . '/../temp');

// Enable Nette Debugger for error visualisation & logging
if (file_exists(__DIR__ . '/../.dev'))
{
	$configurator->setDebugMode(TRUE); // setup debug environment just by creating a file - vagrant
}
$configurator->enableDebugger();

$loader = new Nette\Loaders\RobotLoader;
$loader->setCacheStorage(new Nette\Caching\Storages\FileStorage(TEMP_DIR . '/cache'));
$loader->addDirectory(array(APP_DIR, TESTS_DIR . '/cases', TESTS_DIR . '/inc'));
$loader->register();

$diContainer = $configurator->createContainer();

Orm\PerformanceHelper::$keyCallback = NULL;
