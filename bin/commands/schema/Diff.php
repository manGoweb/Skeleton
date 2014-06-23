<?php

namespace Bin\Commands\Schema;

use App\Models\Model;
use Bin\Commands\Command;
use Bin\Services\SchemaBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Schema\Comparator;


class Diff extends Command
{

	protected function configure()
	{
		$this->setName('schema:diff')
			->setDescription('Builds database schema from mappers');
	}

	public function invoke(Connection $connection, Model $model, SchemaBuilder $schema)
	{
		$current = $connection->getSchemaManager()->createSchema();
		$target = $schema->create($model);
		$sqls = Comparator::compareSchemas($current, $target)->toSql(new MySqlPlatform());
		foreach ($sqls as $sql)
		{
			if ($sql === 'DROP TABLE migrations')
			{
				continue;
			}
			$this->out->writeln($sql);
		}
	}

}
