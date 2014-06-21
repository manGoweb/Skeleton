<?php

namespace Bin\Commands;

use Nette\DI\Container;
use Symfony\Component\Console\Command\Command as SCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;


abstract class Command extends SCommand
{

	/**
	 * @var InputInterface
	 */
	protected $in;

	/**
	 * @var OutputInterface|ConsoleOutput
	 */
	protected $out;

	final protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->in = $input;
		$this->out = $output;

		/** @var Container $container */
		$container = $this->getHelper('container')->getContainer();
		return $container->callMethod([$this, 'invoke']);
	}

}
