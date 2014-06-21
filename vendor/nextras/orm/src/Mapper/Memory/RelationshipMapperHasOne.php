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
use Nextras\Orm\Entity\IEntity;
use Nextras\Orm\Entity\Collection\ICollection;
use Nextras\Orm\Entity\Reflection\PropertyMetadata;
use Nextras\Orm\Mapper\IRelationshipMapper;
use Nextras\Orm\NotSupportedException;


/**
 * ManyHasOne relationship mapper for memory mapping.
 */
class RelationshipMapperHasOne extends Object implements IRelationshipMapper
{
	/** @var PropertyMetadata */
	protected $metadata;


	public function __construct(PropertyMetadata $metadata)
	{
		$this->metadata = $metadata;
	}


	public function getIterator(IEntity $parent, ICollection $collection)
	{
		$key = $parent->getForeignKey($this->metadata->name);
		return [$key ? $collection->getById($key) : NULL];
	}


	public function getIteratorCount(IEntity $parent, ICollection $collection)
	{
		throw new NotSupportedException();
	}

}
