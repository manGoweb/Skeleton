<?php

namespace App\Models\Structs;

use App\Models\Rme\Attendee;
use App\Models\Rme\Token;
use DateTime;
use Nette\Object;
use Nette\Security\Passwords;
use Nette\Utils\Random;


class TokenManager extends Object
{

	/**
	 * @var Attendee
	 */
	private $attendee;

	/**
	 * @param Attendee $user
	 */
	public function __construct(Attendee $user)
	{
		$this->attendee = $user;
	}

	public function createToken()
	{
		$token = new Token();
		$plain = Random::generate(30);
		$token->hash = Passwords::hash($plain);

		$this->attendee->tokens[] = $token;
	}

	public function useToken($id, $plain)
	{
		$token = NULL;
		foreach ($this->attendee->tokens as $token)
		{
			if ($token->id === $id)
			{
				break;
			}
			// now work with $token
		}
		if ($token && !$token->isUsed() && $token->isHashValid($plain))
		{
			$token->usedAt = new DateTime();
			return TRUE;
		}
		return FALSE;
	}

}
