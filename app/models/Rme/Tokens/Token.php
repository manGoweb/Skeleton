<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use DateInterval;
use DateTime;
use Nette\Security\Passwords;
use Nextras\Orm\Relationships\ManyHasOne;


/**
 * @property string $hash
 * @property NULL|DateTime $usedAt
 *
 * @property ManyHasOne|Attendee $user {m:1 AttendeesRepository}
 */
class Token extends Entity
{

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

	/**
	 * @param string $hash
	 * @return bool
	 */
	public function isHashValid($hash)
	{
		return Passwords::verify($hash, $this->hash);
	}

}
