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

	static $keywords1 = 'SELECT|(?:ON\s+DUPLICATE\s+KEY)?UPDATE|CREATE|DROP|TABLE|ALTER|INSERT(?:\s+INTO)?|REPLACE(?:\s+INTO)?|DELETE|CALL|UNION|FROM|WHERE|HAVING|GROUP\s+BY|ORDER\s+BY|LIMIT|OFFSET|SET|VALUES|LEFT\s+JOIN|INNER\s+JOIN|TRUNCATE';
	static $keywords2 = 'ALL|DISTINCT|DISTINCTROW|IGNORE|AS|USING|ON|AND|OR|IN|IS|NOT|NULL|LIKE|RLIKE|REGEXP|TRUE|FALSE';

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
			$this->out->writeln($this->formatSql($sql) . ';');
		}
	}

	protected function formatSql($sql)
	{
		$sql = preg_replace('~\b(' . static::$keywords1 . ')\b~', '<fg=green>$0</fg=green>', $sql);
		$sql = preg_replace('~\b(' . static::$keywords2 . ')\b~', '<fg=blue>$0</fg=blue>', $sql);
		return $sql;
	}

}
