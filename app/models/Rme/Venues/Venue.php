<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use App\Models\Structs\LatLng;


/**
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $street
 * @property string $city
 *
 * @property Marathon[] $marathons {1:m MarathonsRepository $venue}
 */
class Venue extends Entity
{

	/**
	 * @return LatLng
	 */
	public function getLatLng()
	{
		return new LatLng($this->lat, $this->lng);
	}

}
