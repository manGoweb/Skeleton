<?php

namespace Bin\Commands\Scaffolding;

use Bin\Commands\Command;
use Bin\Services\Scaffolding;
use Inflect\Inflect;
use Symfony\Component\Console\Input\InputArgument;


class Rme extends Command
{

	protected function configure()
	{
		$this->setName('scaffolding:rme')
			->setDescription('Creates classes for new repository, mapper and entity')
			->addArgument('entityName', InputArgument::REQUIRED);
	}

	public function invoke(Scaffolding $scaffolding)
	{
		$name = ucFirst($this->in->getArgument('entityName'));

		$scaffolding->createRepository($name);
		$scaffolding->createMapper($name);

		$params = [];
		foreach ($this->in->getVariadics() as $arg)
		{
			list($param, $type) = explode(':', $arg) + [NULL, 'mixed'];
			$params[$param] = $type;
		}
		$scaffolding->createEntity($name, $params);
	}

}
