<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../app/config/Configurator.php';
require_once __DIR__ . '/../inc/TestsRootConfigurator.php';

$configurator = new Tests\TestsRootConfigurator(isset($_GET['testDbName']) ? $_GET['testDbName'] : NULL);

$configurator->enableDebugger();
$configurator
	->createRobotLoader()
	->addDirectory(__DIR__ . '/../inc')
	->register()
;

$context = $configurator->createContainer();
$context->application->run();
