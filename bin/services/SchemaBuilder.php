<?php

namespace Bin\Services;

use App\Models\Orm\Mapper;
use App\Models\Orm\Repository;
use App\Models\Orm\RepositoryContainer;
use App\Models\Orm\SqlConventional;
use App\NotImplementedException;
use Doctrine\DBAL\Schema\Schema;
use Inflect\Inflect;
use Nette\Object;
use Orm\AnnotationMetaData;
use Orm\AnnotationsParser;
use Orm\MetaData;
use Orm\RelationshipMetaData;
use Orm\RelationshipMetaDataManyToMany;
use Orm\RelationshipMetaDataManyToOne;
use Orm\RelationshipMetaDataOneToMany;


class SchemaBuilder extends Object
{


	/**
	 * @var RepositoryContainer
	 */
	private $repos;

	/**
	 * @var AnnotationsParser
	 */
	private $parser;

	public function __construct(RepositoryContainer $repos)
	{
		$this->repos = $repos;
		$this->parser = $this->repos->getContext()->getService('annotationsParser');
	}

	public function create()
	{
		$schema = new Schema();
		foreach ($this->repos->getRepositoryClasses() as $repoClass)
		{
			/** @var Repository $repo */
			$repo = $this->repos->getRepository($repoClass);

			$this->createTable($schema, $repo);
		}
		return $schema;
	}

	/**
	 * @param string $entityClass
	 * @return MetaData
	 */
	private function getEntityMetaData($entityClass)
	{
		$meta = new MetaData($entityClass);
		AnnotationMetaData::getMetaData($meta, $this->parser);
		return $meta;
	}

	protected function createTable(Schema $schema, Repository $repo)
	{
		/** @var Mapper $mapper */
		$mapper = $repo->getMapper();

		$conventional = new SqlConventional($mapper);

		$tableName = $mapper->getTableName();
		$table = $schema->createTable($tableName);

		$meta = $this->getEntityMetaData($repo->getEntityClassName());

		foreach ($meta->toArray() as $paramName => $param)
		{
			$name = $this->toUnderscoreCase($paramName);
			$options = ['notnull' => !isset($param['types']['null'])];

			unset($param['types']['null']);

			/** @var NULL|RelationshipMetaData $relation */
			$relation = $param['relationshipParam'];
			if ($relation instanceof RelationshipMetaDataOneToMany)
			{
				// no change to this table
				continue;
			}
			else if ($relation instanceof RelationshipMetaDataManyToMany)
			{
				// no change to this table, but want to create a join table
				/** @var NULL|RelationshipMetaDataManyToMany $relation */

				if ($relation->getWhereIsMapped() === RelationshipMetaDataManyToMany::MAPPED_THERE)
				{
					continue;
				}
				// mapped here, create mapping table

				/** @var Repository $targetRepo */
				$childRepo = $this->repos->getRepository($relation->getChildRepository());
				$joinTableName = $conventional->getManyToManyTable($repo, $childRepo);
				$joinTable = $schema->createTable($joinTableName);

				$columnThis = Inflect::singularize($paramName) . '_id';
				$joinTable->addColumn($columnThis, 'integer', ['unsigned' => TRUE]);
				/** @noinspection PhpParamsInspection */
				$joinTable->addForeignKeyConstraint($tableName, [$columnThis], ['id']);

				$columnThat = Inflect::singularize($relation->getChildParam()) . '_id';
				$joinTable->addColumn($columnThat, 'integer', ['unsigned' => TRUE]);

				/** @var Mapper $childMapper */
				$childMapper = $childRepo->getMapper();
				/** @noinspection PhpParamsInspection */
				$joinTable->addForeignKeyConstraint($childMapper->getTableName(), [$columnThat], ['id']);

				$joinTable->setPrimaryKey([$columnThis, $columnThat]);
				continue;
			}
			else if ($relation instanceof RelationshipMetaDataManyToOne)
			{
				// add foo_id
				/** @var NULL|RelationshipMetaDataManyToOne $relation */
				$table->addColumn("{$paramName}_id", 'integer', $options);
			}
			else if ($relation === NULL && isset($param['types']['id']))
			{
				$table->addColumn($name, 'integer', $options + ['unsigned' => TRUE, 'autoincrement' => TRUE]);
			}
			else if ($relation === NULL)
			{
				$typesByPriority = ['id', 'datetime', 'string', 'float', 'integer'];

				foreach ($typesByPriority as $type)
				{
					if (isset($param['types'][$type]))
					{
						$table->addColumn($name, $type, $options);
						break;
					}
				}
			}
			else
			{
				throw new NotImplementedException;
			}
		}

		$table->setPrimaryKey(['id']);
	}

	/**
	 * @param string $key
	 * @return string
	 */
	private function toUnderscoreCase($key)
	{
		$s = preg_replace('#(.)(?=[A-Z])#', '$1_', $key);
		return strtolower($s);
	}

}
