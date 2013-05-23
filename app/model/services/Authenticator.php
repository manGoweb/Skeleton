<?php

namespace App;

use Nette\Object;
use Nette\Security;
use Orm\EntityToArray;
use Clevispace\PasswordHashCalculator;


/**
 * Základní authenticator
 */
class Authenticator extends Object implements Security\IAuthenticator
{
	/** @var UsersRepository */
	private $users;

	/** @var PasswordHashCalculator */
	private $calculator;


	public function __construct(UsersRepository $users, PasswordHashCalculator $calculator)
	{
		$this->users = $users;
		$this->calculator = $calculator;
	}

	/**
	 * @param array
	 * @return Security\IIdentity
	 * @throws Security\AuthenticationException
	 */
	public function authenticate(array $args)
	{
		$username = $args[self::USERNAME];
		$password = $args[self::PASSWORD];

		/** @var User $user */
		$user = $this->users->getByUsername($username);
		if (!$user)
		{
			throw new Security\AuthenticationException('Username does not exist.');
		}

		if (!$this->calculator->verify($password, $user->password, $user->username))
		{
			throw new Security\AuthenticationException('Wrong username or password.');
		}

		return new Security\Identity($user->id, NULL, $user->toArray(EntityToArray::AS_ID));
	}

}
