<?php

namespace Bin\Commands\Scaffolding\Test;

use Bin\Commands\Command;
use Bin\Services\Scaffolding;
use Inflect\Inflect;
use Symfony\Component\Console\Input\InputArgument;


class Unit extends Command
{

	protected function configure()
	{
		$this->setName('scaffolding:test:unit')
			->setDescription('Creates new unit test')
			->addArgument('name', InputArgument::REQUIRED);
	}

	public function invoke(Scaffolding $scaffolding)
	{
		$name = ucFirst($this->in->getArgument('name'));

		$path = $scaffolding->createUnitTest($name);
		$this->out->writeln('<info>Created files:</info>');
		$this->out->writeln('  ' . $this->formatPath($path));
	}

	private function formatPath($path)
	{
		$root = realpath(__DIR__ . '/../../../../');
		$path = realpath($path);
		$relative = substr($path, strlen($root) + 1);
		return preg_replace('~/([a-z0-9]+)(\.[a-z0-9]+)?$~ims', '/<fg=blue>$1</fg=blue>$2', $relative);
	}

}
