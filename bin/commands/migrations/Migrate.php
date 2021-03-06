<?php

namespace Bin\Commands\Migrations;

use App\Migrations\PhpClass;
use Bin\Commands\Command;
use Nette\Database\Context;
use Nette\DI\Container;
use Nextras\Migrations\Drivers\MySqlNetteDbDriver;
use Nextras\Migrations\Drivers\NetteDbDriver;
use Nextras\Migrations\Engine\Runner;
use Nextras\Migrations\Entities\Group;
use Nextras\Migrations\Extensions;
use Nextras\Migrations\Printers\Console;
use Symfony\Component\Console\Input\InputOption;


class Migrate extends Command
{

	protected function configure()
	{
		$this->setName('migrations:migrate')
			->setDescription('Updates database schema by running all new migrations')
			->setHelp("If table 'migrations' does not exist in current database," .
				"it is created automatically.")
			->addOption('reset', 'r', InputOption::VALUE_NONE, 'Drop all tables prior to running all migrations');
	}

	public function invoke(Container $container, Context $db)
	{
		$driver = new MySqlNetteDbDriver($db, 'migrations');
		$runner = new Runner($driver, new Console);

		$g = new Group();
		$g->directory = __DIR__ . '/../../../migrations/struct';
		$g->dependencies = [];
		$g->enabled = TRUE;
		$g->name = 'struct';
		$runner->addGroup($g);
		$runner->addExtensionHandler('sql', new Extensions\NetteDbSql($db));
		$runner->addExtensionHandler('php', new PhpClass([
			'db' => $db,
		], $container));

		$this->runMigrations($db, $runner, $driver);
	}

	private function runMigrations(Context $db, Runner $runner, NetteDbDriver $driver)
	{
		try
		{
			$mode = $this->in->getOption('reset') ? Runner::MODE_RESET : Runner::MODE_CONTINUE;
			$runner->run($mode);
		}
		catch (\PDOException $e)
		{
			if ($e->getCode() !== '42S02')
			{
				throw $e;
			}

			// lets hope locale is english
			if (!preg_match("~Table '.*?\\.migrations' doesn't exist~", $e->getMessage()))
			{
				throw $e;
			}

			// migrations table not found, create and run again
			$this->initMigrations($db, $runner);
			$driver->unlock();
			$this->runMigrations($db, $runner, $driver);
		}
	}

	private function initMigrations(Context $db, Runner $runner)
	{
		ob_start();
		$runner->run($runner::MODE_INIT);
		$sql = ob_get_clean();
		$db->query($sql);
		$this->out->writeln('<info>Migrations table created</info>');
	}

}
