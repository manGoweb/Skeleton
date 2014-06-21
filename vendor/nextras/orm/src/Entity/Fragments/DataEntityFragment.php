<?php

/**
 * This file is part of the Nextras\ORM library.
 *
 * @license    MIT
 * @link       https://github.com/nextras/orm
 * @author     Jan Skrasek
 */

namespace Nextras\Orm\Entity\Fragments;

use Nextras\Orm\Entity\IEntity;
use Nextras\Orm\Entity\IPropertyContainer;
use Nextras\Orm\Entity\IPropertyInjection;
use Nextras\Orm\Entity\Reflection\EntityMetadata;
use Nextras\Orm\Entity\Reflection\PropertyMetadata;
use Nextras\Orm\Entity\ToArrayConverter;
use Nextras\Orm\Model\MetadataStorage;
use Nextras\Orm\Relationships\IRelationshipCollection;
use Nextras\Orm\Relationships\IRelationshipContainer;
use Nextras\Orm\Repository\IRepository;
use Nextras\Orm\InvalidArgumentException;
use Nextras\Orm\InvalidStateException;


abstract class DataEntityFragment extends RepositoryEntityFragment implements IEntity
{
	/** @var EntityMetadata */
	protected $metadata;

	/** @var array */
	private $data = [];

	/** @var array */
	private $validated = [];

	/** @var array */
	private $modified = [];


	public function __construct()
	{
		parent::__construct();
		$this->modified[NULL] = TRUE;
		$this->metadata = $this->createMetadata();
	}


	public function getMetadata()
	{
		return $this->metadata;
	}


	public function setValue($name, $value)
	{
		$metadata = $this->metadata->getProperty($name);
		if ($metadata->isReadonly) {
			throw new InvalidArgumentException("Property '$name' is read-only.");
		}

		$this->_setValue($metadata, $name, $value);
		return $this;
	}


	public function isModified($name = NULL)
	{
		if ($name === NULL) {
			return (bool) $this->modified;
		}

		$this->metadata->getProperty($name);
		return isset($this->modified[NULL]) || isset($this->modified[$name]);
	}


	public function setAsModified($name = NULL)
	{
		$this->modified[$name] = TRUE;
		return $this;
	}


	public function setReadOnlyValue($name, $value)
	{
		$metadata = $this->metadata->getProperty($name);
		$this->_setValue($metadata, $name, $value);
		return $this;
	}


	public function & getValue($name, $allowNull = FALSE)
	{
		$property = $this->metadata->getProperty($name);
		return $this->_getValue($property, $name, $allowNull);
	}


	public function hasValue($name)
	{
		if (!$this->metadata->hasProperty($name)) {
			return FALSE;
		}

		$value = $this->_getValue($this->metadata->getProperty($name), $name, TRUE);
		return isset($value);
	}


	public function getProperty($name)
	{
		$metadata = $this->metadata->getProperty($name);
		if (!isset($this->data[$name])) {
			$this->data[$name] = NULL;
		}
		if ($metadata->container && !is_object($this->data[$name])) {
			$class = $metadata->container;
			$this->data[$name] = new $class($this, $metadata, $this->data[$name]);
			$this->validated[$name] = TRUE;
		}
		return $this->data[$name];
	}


	public function getForeignKey($name)
	{
		$metadata = $this->metadata->getProperty($name);
		if (!in_array($metadata->relationshipType, [PropertyMetadata::RELATIONSHIP_MANY_HAS_ONE, PropertyMetadata::RELATIONSHIP_ONE_HAS_ONE], TRUE)) {
			throw new InvalidArgumentException("There is no HAS ONE relationship in '$name' property.");
		}

		if (isset($this->validated[$name])) {
			return $this->data[$name]->getPrimaryValue();
		}

		return $this->data[$name];
	}


	public function toArray($mode = self::TO_ARRAY_RELATIONSHIP_AS_IS)
	{
		return ToArrayConverter::toArray($this, $mode);
	}


	protected function onLoad(IRepository $repository, EntityMetadata $metadata, array $data)
	{
		parent::onLoad($repository, $metadata, $data);
		$this->metadata = $metadata;
		foreach ($metadata->storageProperties as $property) {
			if (isset($data[$property])) {
				$this->data[$property] = $data[$property];
			}
		}
	}


	protected function onPersist($id)
	{
		parent::onPersist($id);
		$this->setValue('id', $id);
		$this->modified = [];
	}


	protected function _setValue(PropertyMetadata $metadata, $name, $value)
	{
		if (!isset($this->data[$name])) {
			$this->data[$name] = NULL;
		}

		if ($metadata->container && !is_object($this->data[$name])) {
			$class = $metadata->container;
			$this->data[$name] = new $class($this, $metadata, $this->data[$name]);
			$this->validated[$name] = TRUE;
		}

		if ($metadata->hasSetter) {
			call_user_func([$this, 'set' . $name], $value);
			return;
		}

		if ($this->data[$name] instanceof IPropertyInjection || $this->data[$name] instanceof IPropertyContainer) {
			$this->data[$name]->setInjectedValue($value);
		} else {
			if (!$metadata->isValid($value)) {
				throw new InvalidArgumentException("Property '$name' is invalid.");
			}
			$this->data[$name] = $value;
			$this->modified[$name] = TRUE;
		}

		$this->validated[$name] = TRUE;
	}


	protected function & _getValue(PropertyMetadata $metadata, $name, $allowNull = FALSE)
	{
		if (!isset($this->data[$name])) {
			$this->data[$name] = NULL;
		}

		if (!$metadata->isReadonly && !isset($this->validated[$name]) && !$metadata->container) {
			if (!($allowNull && empty($this->data[$name]))) {
				$this->_setValue($metadata, $name, $this->data[$name]);
			}

		} elseif ($metadata->container && !is_object($this->data[$name])) {
			$class = $metadata->container;
			$this->data[$name] = new $class($this, $metadata, $this->data[$name]);
			$this->validated[$name] = TRUE;
		}

		if ($metadata->hasGetter) {
			$value = call_user_func([$this, 'get' . $name]);
			return $value;
		}

		if ($this->data[$name] instanceof IPropertyContainer) {
			$value = $this->data[$name]->getInjectedValue();
			return $value;
		} else {
			if (!isset($this->data[$name]) && !$metadata->isNullable && !$allowNull) {
				throw new InvalidStateException("Property '$name' is not set.");
			}
			return $this->data[$name];
		}
	}


	public function __clone()
	{
		parent::__clone();
		$id = $this->getValue('id');
		foreach ($this->getMetadata()->storageProperties as $property) {
			if ($this->getValue($property) && is_object($this->data[$property])) {
				if ($this->data[$property] instanceof IRelationshipCollection) {
					$data = iterator_to_array($this->data[$property]->get());
					$this->setValue('id', NULL);
					$this->data[$property] = clone $this->data[$property];
					$this->data[$property]->setParent($this);
					$this->data[$property]->set($data);
					$this->setValue('id', $id);

				} elseif ($this->data[$property] instanceof IRelationshipContainer) {
					$this->data[$property]->setParent($this);

				} else {
					$this->data[$property] = clone $this->data[$property];
				}
			}
		}
		$this->setValue('id', NULL);
	}


	protected function createMetadata()
	{
		return MetadataStorage::get(get_class($this));
	}

}
