<?php

namespace App\Models\Rme;

use App\Models\Orm\Repository;


class MarathonsRepository extends Repository
{

	/**
	 * @return NULL|Marathon
	 */
	public function getLatest()
	{
		return $this->findAll()->orderBy('heldAt')->limitBy(1)->fetch();
	}

}
