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

		$repo = $scaffolding->createRepository($name);
		$this->out->writeln('<info>Created files:</info>');
		$this->out->writeln('  ' . $this->formatPath($repo));
		$mapper = $scaffolding->createMapper($name);
		$this->out->writeln('  ' . $this->formatPath($mapper));

		$params = [];
		foreach ($this->in->getVariadics() as $arg)
		{
			list($param, $type) = explode(':', $arg) + [NULL, 'mixed'];
			$params[$param] = $type;
		}
		$entity = $scaffolding->createEntity($name, $params);
		$this->out->writeln('  ' . $this->formatPath($entity));

		$this->out->writeln("\n<comment>Don't forget to add repository to your Model class</comment>");

		$plural = Inflect::pluralize($name);
		$repoClass = ucFirst($plural) . 'Repository';
		$param = lcFirst($plural);
		$this->out->writeln(" * @property-read $repoClass \$$param");
	}

	private function formatPath($path)
	{
		$root = realpath(__DIR__ . '/../../../');
		$path = realpath($path);
		$relative = substr($path, strlen($root) + 1);
		return preg_replace('~/([a-z0-9]+)(\.[a-z0-9]+)?$~ims', '/<fg=blue>$1</fg=blue>$2', $relative);
	}

}
