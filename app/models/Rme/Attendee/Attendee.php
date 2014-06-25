<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use App\Models\Structs\TokenManager;
use Nextras\Orm\Relationships\ManyHasMany;


/**
 * @property string $name
 * @property string $email
 *
 * @property Token[] $tokens {1:m TokensRepository $user}
 * @property ManyHasMany|Marathon[] $marathons {m:m MarathonsRepository primary $attendees}
 */
class Attendee extends Entity
{

	/** @var TokenManager */
	private $tokenManager;

	public function __construct($email, $name)
	{
		parent::__construct();

		$this->tokenManager = new TokenManager($this);

		$this->email = $email;
		$this->name = $name;
	}

}
