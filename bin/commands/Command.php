<?php

namespace Bin\Commands;

use App\ImplementationException;
use Bin\Support\VariadicArgvInput;
use Nette\DI\Container;
use Symfony\Component\Console\Command\Command as SCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * @method invoke() with arguments filled from container
 */
abstract class Command extends SCommand
{

	/**
	 * @var VariadicArgvInput
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

		if (!method_exists($this, 'invoke'))
		{
			$class = get_class($this);
			throw new ImplementationException("Command $class must define method 'invoke'.");
		}

		/** @var Container $container */
		$container = $this->getHelper('container')->getContainer();
		return $container->callMethod([$this, 'invoke']);
	}

}
