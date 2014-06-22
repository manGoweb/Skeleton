<?php

namespace Tests;

use Nette\DI\Container;
use Tester;


/**
 * Adds support for injected properties
 */
class TestCase extends Tester\TestCase
{

	/**
	 * @var \Nette\DI\Container
	 */
	private $container;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	public function runTest($name, array $args = [])
	{
		$this->container->callInjects($this);
		$this->setUp();
		try {
			call_user_func_array(array($this, $name), $args);
		} catch (\Exception $e) {}

		try
		{
			$this->tearDown();
		}
		catch (\Exception $tearDownEx)
		{
			throw isset($e) ? $e : $tearDownEx;
		}

		if (isset($e))
		{
			throw $e;
		}
		parent::runTest($name, $args);
	}

}
