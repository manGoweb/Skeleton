<?php

namespace Bin\Commands;

use App\Models\Services\QueueSubscriber;
use App\Models\Tasks\Task;
use Nette\DI\Container;


class Worker extends Command
{

	protected function configure()
	{
		$this->setName('worker')
			->setDescription('Queue worker (should be run with supervisord)');
	}

	public function invoke(QueueSubscriber $queue, Container $container)
	{
		$this->out->writeln('<info>Worker is running...</info>');
		while (TRUE)
		{
			$queue->pop(function(Task $task) use ($container, $queue) {
				$this->out->writeln(get_class($task));
				$container->callMethod([$task, 'run']);
			});
		}
	}

}
