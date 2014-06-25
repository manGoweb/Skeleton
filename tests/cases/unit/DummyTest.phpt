<?php

namespace Tests\Cases\Unit;

use App\Models\Orm\Model;
use Tester\Assert;
use Tests\TestCase;


$container = require __DIR__ . '/../../bootstrap.php';

class DummyTest extends TestCase
{

	/**
	 * @var Model @inject
	 */
	public $model;

	public function testSomething()
	{
		echo "something\n";
		Assert::same(TRUE, TRUE);
	}

}

runTests(__FILE__, $container);
