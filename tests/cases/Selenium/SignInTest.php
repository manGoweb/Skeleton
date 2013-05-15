<?php

namespace Tests\Selenium;

/**
 * Test přihlášení.
 *
 * @author Tomas Susanka
 */
class SignIn_Test extends SeleniumTestCase
{

	/**
	 * Testuje přihlášení.
	 * Využívá Authentication feature.
	 *
	 * @author Tomas Susanka
	 */
	public function testSignIn()
	{
		$result = $this->auth->login(
			'František',
			'Dobrota'
		);
		$this->assertFalse($result);

		$result = $this->auth->login(
			$this->context->parameters['selenium']['testUser']['username'],
			$this->context->parameters['selenium']['testUser']['password']
		);
		$this->assertTrue($result);
	}

}
