<?php

namespace App\Models;

use App\Models\Rme\MarathonsRepository;
use App\Models\Rme\UsersRepository;
use App\Models\Rme\VenuesRepository;
use Nextras\Orm\Model\DIModel;


/**
 * @property-read UsersRepository $users
 * @property-read MarathonsRepository $marathons
 * @property-read VenuesRepository $venues
 */
class Model extends DIModel
{

	/**
	 * @return array
	 */
	public function getRepositories()
	{
		return $this->repositories;
	}

}
