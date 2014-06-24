<?php

namespace App\Models\Rme;

use App\Models\Orm\Entity;


/**
 * @property string $name
 *
 * @property Token[] $tokens {1:m TokensRepository $user}
 */
class User extends Entity
{

}
