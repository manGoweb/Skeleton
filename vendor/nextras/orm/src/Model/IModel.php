<?php

/**
 * This file is part of the Nextras\ORM library.
 *
 * @license    MIT
 * @link       https://github.com/nextras/orm
 * @author     Jan Skrasek
 */

namespace Nextras\Orm\Model;

use Nextras\Orm\Entity\IEntity;
use Nextras\Orm\Repository\IRepository;


interface IModel
{

	/**
	 * Returns TRUE if repository with name is attached to model.
	 * @param  string
	 * @return bool
	 */
	function hasRepositoryByName($name);


	/**
	 * Returns repository by repository name.
	 * @param  string
	 * @return IRepository
	 */
	function getRepositoryByName($name);


	/**
	 * Returns TRUE if repository class is attached to model.
	 * @param  string
	 * @return bool
	 */
	function hasRepository($className);


	/**
	 * Returns repository by repository class.
	 * @param  string
	 * @return IRepository
	 */
	function getRepository($className);


	/**
	 * Returns repository associated for entity type.
	 * @param  IEntity
	 * @return IRepository
	 */
	function getRepositoryForEntity(IEntity $entity);


	/**
	 * Returns entity metadata storage.
	 * @return MetadataStorage
	 */
	function getMetadataStorage();

}
