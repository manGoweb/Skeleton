<?php

/**
 * This file is part of the Nextras\ORM library.
 *
 * @license    MIT
 * @link       https://github.com/nextras/orm
 * @author     Jan Skrasek
 */

namespace Nextras\Orm\Entity\Collection;


interface IEntityContainer extends IEntityPreloadContainer
{

	/**
	 * Returms entity by joining key.
	 * @param int|FALSE
	 */
	function getEntity($key);

}
