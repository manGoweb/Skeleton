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


Debugger::$strictMode = TRUE;
Debugger::enable();

$loader = new Nette\Loaders\RobotLoader;
$loader->setCacheStorage(new Nette\Caching\Storages\FileStorage(TEMP_DIR . '/cache'));
$loader->addDirectory(array(APP_DIR, TESTS_DIR . '/cases', TESTS_DIR . '/inc', LIBS_DIR . '/clevispace'));
$loader->register();

$configurator = new TestsConfigurator;
$diContainer = $configurator->createContainer();

Orm\PerformanceHelper::$keyCallback = NULL;
