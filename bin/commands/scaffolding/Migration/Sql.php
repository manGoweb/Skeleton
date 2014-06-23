<?php

namespace Bin\Commands\Scaffolding\Migration;

use Bin\Commands\Scaffolding\Command;
use Bin\Services\Scaffolding;
use Symfony\Component\Console\Input\InputArgument;


class Sql extends Command
{

	protected function configure()
	{
		$this->setName('scaffolding:migration:sql')
			->setDescription('Creates new sql migration')
			->addArgument('note', InputArgument::OPTIONAL, 'Migration note');
	}

	public function invoke(Scaffolding $scaffolding)
	{
		$file = $scaffolding->createSqlMigration($this->in->getArgument('note'));
		$this->writeCreatedFilesHeader();
		$this->writeCreatedFile($file);
	}

}
