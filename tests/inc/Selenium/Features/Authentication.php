<?php

namespace Tests\Selenium\Features;

use Nette\Object;
use Se34\BrowserSession;
use Tests\Selenium\Pages;


/**
 * Přihlašování/odhlašování.
 *
 * @author Tomáš Sušáka
 */
class Authentication extends Object
{

	/**
	 * @var BrowserSession
	 */
	private $session;


	function __construct(BrowserSession $session)
	{
		$this->session = $session;
	}

	/**
	 * Přihlásí uživatele.
	 *
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function login($username, $password)
	{
		$credentials = array(
			'username' => $username,
			'password' => $password
		);
		$loginPage = new Pages\SignIn($this->session);

		$nextPage = $loginPage
			->navigate()
			->fill($credentials)
			->clickSubmit();

		return !($nextPage instanceof Pages\SignIn);
	}
}
