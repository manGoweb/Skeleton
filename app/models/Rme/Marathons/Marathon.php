<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use DateTime;
use Nextras\Orm\Relationships\ManyHasOne;


/**
 * @property string $name
 * @property Venue $venue
 * @property DateTime $heldAt
 *
 * @property ManyHasOne|Venue $venue {m:1 VenuesRepository}
 */
class Marathon extends Entity
{

}
