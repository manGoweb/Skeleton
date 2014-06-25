<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use DateTime;
use Nextras\Orm\Relationships\ManyHasMany;
use Nextras\Orm\Relationships\ManyHasOne;
use Nextras\Orm\Relationships\OneHasMany;


/**
 * @property string $name
 * @property DateTime $heldAt
 *
 * @property ManyHasOne|Venue $venue {m:1 VenuesRepository}
 * @property ManyHasMany|Attendee[] $attendees {m:m AttendeesRepository $marathons}
 */
class Marathon extends Entity
{

}
