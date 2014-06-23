<?php

namespace App\Controls;

use App\Models\Structs\LatLng;


class Map extends Control
{

	protected function renderDefault(LatLng $latLng, $zoom = 10)
	{
		$this->template->latLng = $latLng;
		$this->template->zoom = $zoom;
	}

}
