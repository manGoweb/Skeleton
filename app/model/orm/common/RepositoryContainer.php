<?php

namespace App;

use Nette;
use Clevis\Skeleton;


/**
 * Collection of IRepository.
 *
 * Cares about repository initialization.
 * It is the entry point into model from other parts of application.
 * Stores container of services which other objects may need.
 */
class RepositoryContainer extends Skeleton\Orm\RepositoryContainer
{

}
