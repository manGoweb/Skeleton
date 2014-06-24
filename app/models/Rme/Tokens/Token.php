<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use DateInterval;
use DateTime;
use Nette\Utils\Random;
use Nextras\Orm\Relationships\ManyHasOne;


/**
 * @property string $hash
 * @property NULL|DateTime $usedAt
 *
 * @property ManyHasOne|User $user {m:1 UsersRepository}
 */
class Token extends Entity
{

	public function __construct()
	{
		parent::__construct();
		$this->hash = Random::generate(20);
	}

	/**
	 * @return bool
	 */
	public function isExpired()
	{
		$then = clone $this->createdAt;
		$expiresAt = $then->add(new DateInterval('P3D'));
		$now = new DateTime();

		return $expiresAt < $now;
	}

	/**
	 * @return bool
	 */
	public function isUsed()
	{
		return (bool) $this->usedAt;
	}

}
