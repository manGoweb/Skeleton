<?php

namespace App\Models\Rme;

use App\Models\Orm\Repository;


class AttendeesRepository extends Repository
{

	/**
	 * @param $email
	 * @return Attendee|NULL
	 */
	public function getByEmail($email)
	{
		return $this->findBy(['email' => $email])->fetch();
	}

}
