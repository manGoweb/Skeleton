<?php

namespace App\Models\Orm;

use DateTime;
use Nextras\Orm\Entity\Entity as NXEntity;


/**
 * @property DateTime $createdAt
 */
class Entity extends NXEntity
{

	public function __construct()
	{
		parent::__construct();
		$this->createdAt = new DateTime();
	}

}
