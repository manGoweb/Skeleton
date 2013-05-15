<?php

namespace Clevispace;

use Nette\Object;
use Nette\Utils\Strings;


/**
 * Osolí a zahashuje heslo metodou bcrypt/blowfish
 *
 * Vyžaduje PHP 5.3.7 a novější
 * http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
 */
class PasswordHashCalculator extends Object
{

	/** @var int nastavuje počet opakování hashe 2^n (časovou náročnost) */
	public $rounds = 13;


	/**
	 * Zahashuje heslo
	 *
	 * @param string
	 * @return string|bool
	 */
	public function hash($password)
	{
		$hash = crypt($password, $this->getSalt());

		if (strlen($hash) > 13) return $hash;

		return FALSE;
	}

	/**
	 * Ověří heslo proti hashi
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function verify($password, $hash, $username = NULL)
	{
		// SHA-1 pro kompatibilitu se stávajícími hesly
		// todo: nuceně přepočítat?
		if (strlen($hash) === 40)
		{
			return $hash === sha1($username . $password);
		}

		$passwordHash = crypt($password, $hash);

		return $passwordHash === $hash;
	}

	/**
	 * Vrací sůl a nastavení pro hash
	 *
	 * @return string
	 */
	private function getSalt()
	{
		$salt = sprintf('$2y$%02d$', $this->rounds);

		$salt .= Strings::random(22, '0-9A-Za-z./');

		return $salt;
	}

}
