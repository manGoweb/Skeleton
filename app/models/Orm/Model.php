<?php

namespace App\Models\Orm;

use App\Models\Rme\AttendeesRepository;
use App\Models\Rme\MarathonsRepository;
use App\Models\Rme\TokensRepository;
use App\Models\Rme\VenuesRepository;
use Nextras\Orm\Model\DIModel;


/**
 * @property-read AttendeesRepository $attendees
 * @property-read MarathonsRepository $marathons
 * @property-read VenuesRepository $venues
 * @property-read TokensRepository $tokens
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
