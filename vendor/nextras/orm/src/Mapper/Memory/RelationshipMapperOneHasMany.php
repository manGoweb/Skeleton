<?php

/**
 * This file is part of the Nextras\ORM library.
 *
 * @license    MIT
 * @link       https://github.com/nextras/orm
 * @author     Jan Skrasek
 */

namespace Nextras\Orm\Mapper\Memory;

use Nette\Object;
use Nextras\Orm\Entity\Collection\ICollection;
use Nextras\Orm\Entity\Reflection\PropertyMetadata;
use Nextras\Orm\Entity\IEntity;
use Nextras\Orm\Mapper\IMapper;
use Nextras\Orm\Mapper\IRelationshipMapper;


/**
 * OneHasMany relationship mapper for memory mapping.
 */
class RelationshipMapperOneHasMany extends Object implements IRelationshipMapper
{
	/** @var PropertyMetadata */
	protected $metadata;

	/** @var string */
	protected $joinStorageKey;


	public function __construct(IMapper $targetMapper, PropertyMetadata $metadata)
	{
		$this->metadata = $metadata;
		$this->joinStorageKey = $targetMapper->getStorageReflection()->convertEntityToStorageKey($this->metadata->args[1]);
	}


	public function getIterator(IEntity $parent, ICollection $collection)
	{
		return $collection->findBy(["this->{$this->joinStorageKey}->id" => $parent->id]);
	}


	public function getIteratorCount(IEntity $parent, ICollection $collection)
	{
		return count($this->getIterator($parent, $collection));
	}

}
