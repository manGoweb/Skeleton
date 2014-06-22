<?php

namespace Tests\Cases\Unit;

use App\Models\Model;
use Tester\Assert;
use Tests\TestCase;


$container = require __DIR__ . '/../../bootstrap.php';

class DummyTest extends TestCase
{

	/**
	 * @var Model @inject
	 */
	public $model;

	function testSomething()
	{
		echo "something\n";
		Assert::true(TRUE);
	}

}

runTests(__FILE__, $container);
