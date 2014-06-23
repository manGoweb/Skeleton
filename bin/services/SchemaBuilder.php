<?php

namespace Bin\Services;

use App\Models\Model;
use Doctrine\DBAL\Driver\DrizzlePDOMySql\Connection;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\MySqlSchemaManager;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Nette\Object;
use Nextras\Orm\Repository\Repository;
use Nextras\Orm\StorageReflection\UnderscoredDbStorageReflection;


class SchemaBuilder extends Object
{

	public function create(Model $model)
	{
		$schema = new Schema();
		foreach ($model->getRepositories()['entity'] as $entityClass => $repoClass)
		{
			$this->createTable($schema, $model, $entityClass, $repoClass);
		}
		return $schema;
	}

	protected function createTable(Schema $schema, Model $model, $entityClass, $repoClass)
	{
		/** @var Repository $repo */
		$repo = $model->getRepository($repoClass);
		$tableName = $repo->getMapper()->getTableName();
		$table = $schema->createTable($tableName);

		$meta = $model->getMetadataStorage()->get($entityClass);
		foreach ($meta->getProperties() as $param)
		{
			$type = array_keys($param->types)[0];
			if ($param->name === 'id')
			{
				$type = 'integer';
			}
			$name = UnderscoredDbStorageReflection::underscore($param->name);
			$table->addColumn($name, $type);
		}
		$table->setPrimaryKey($meta->primaryKey);
	}

}
