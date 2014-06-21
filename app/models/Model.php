<?php

namespace App\Models;

use App\Models\Rme\UsersRepository;
use Nextras\Orm\Model\DIModel;


/**
 * @property-read UsersRepository $users
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
