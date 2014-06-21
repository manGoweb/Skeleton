<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;
use DateTime;


/**
 * @property string $name
 * location
 *  - lat
 *  - lng
 *  - name
 * @property DateTime $registerFrom
 * @property DateTime $registerUntil    >from
 * @property DateTime $heldAt           >=until
 * @property NULL|int $maxAttendees     >0 unsigned
 * users registered attendees
 */
class Event extends Entity
{

}
