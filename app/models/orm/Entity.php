<?php

namespace App\Models\Orm;

use Nette\Utils\DateTime;
use Orm;


/**
 * @property-read DateTime $createdAt {default now}
 */
abstract class Entity extends Orm\Entity
{

}