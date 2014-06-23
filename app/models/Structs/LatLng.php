<?php

namespace App\Models\Structs;

use Nette\Object;


/**
 * @property float $lat
 * @property float $lng
 */
class LatLng extends Object
{

	/**
	 * @var float
	 */
	private $lat;

	/**
	 * @var float
	 */
	private $lng;

	/**
	 * @param float $lat
	 * @param float $lng
	 */
	public function __construct($lat, $lng)
	{
		$this->lat = $lat;
		$this->lng = $lng;
	}

	/**
	 * @return float
	 */
	public function getLat()
	{
		return $this->lat;
	}

	/**
	 * @return float
	 */
	public function getLng()
	{
		return $this->lng;
	}

}
