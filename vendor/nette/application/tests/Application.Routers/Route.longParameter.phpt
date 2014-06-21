<?php

/**
 * Test: Nette\Application\Routers\Route with LongParameter
 */

use Nette\Application\Routers\Route,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';

require __DIR__ . '/Route.inc';


$route = new Route('<parameter-longer-than-32-characters>', array(
	'presenter' => 'Presenter',
));

testRouteIn($route, '/any', 'Presenter', array(
	'parameter-longer-than-32-characters' => 'any',
	'test' => 'testvalue',
), '/any?test=testvalue');
