<?php

namespace Bin\Commands\Scaffolding\Migration;

use Bin\Commands\Command;
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
		$this->out->writeln('<info>Created files:</info>');
		$this->out->writeln('  ' . $this->formatPath($file));
	}

	private function formatPath($path)
	{
		$root = realpath(__DIR__ . '/../../../');
		$path = realpath($path);
		$relative = substr($path, strlen($root) + 1);
		return preg_replace('~/([a-z0-9]+)(\.[a-z0-9]+)?$~ims', '/<fg=blue>$1</fg=blue>$2', $relative);
	}

}
