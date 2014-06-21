<?php

namespace App\Models\Orm;

use Nextras\Orm\Mapper\Mapper as NXMapper;


abstract class Mapper extends NXMapper
{

	public function getParameters()
	{
//		$meta = $this->getRepository()->getModel()->getMetadataStorage();
//		$meta->get($this->getRepository()->);
	}

}
