<?php

namespace Clevis\Skeleton;

use Orm;
use Clevis\Skeleton\Orm\EntityRelationsRegistry;


/**
 * Base class for all entities
 */
abstract class Entity extends Orm\Entity
{

	/** @var EntityRelationsRegistry */
	public static $relationsRegistry;


	public static function createMetaData($entityClass)
	{
		$metaData = parent::createMetaData($entityClass);

		return self::$relationsRegistry->completeMetaData(get_called_class(), $metaData);
	}

}
