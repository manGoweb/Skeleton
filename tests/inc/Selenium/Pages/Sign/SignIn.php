<?php

namespace Tests\Selenium\Pages;

use Se34\PageObject;
use Se34\Element;


/**
 * Přihlašovací stránka.
 *
 * @property-read Element $username name=username, input, [type=text]
 * @property-read Element $password name=password, input, [type=password]
 * @property-read Element $submit name=send, input, [type=submit]
 *
 * @author Tomáš Sušánka
 */
class SignIn extends PageObject
{

	protected $presenterName = 'Sign';
	protected $parameters = 'action=in';

	/**
	 * @return SignIn|Homepage
	 */
	public function clickSubmit()
	{
		$this->submit->click();
		$this->session->waitForAjax();
		$this->session->waitForDocument();

		return $this->getNextPage();
	}

}
