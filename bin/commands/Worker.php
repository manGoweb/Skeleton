<?php

namespace Bin\Commands;

use App\Models\Services\Queue;
use App\Models\Tasks\Task;
use Exception;
use Nette\DI\Container;


class Worker extends Command
{

	protected function configure()
	{
		$this->setName('worker')
			->setDescription('Queue worker (should be run with supervisord)');
	}

	public function invoke(Queue $queue, Container $container)
	{
		while (TRUE)
		{
			$queue->watch(function(Task $task, callable $next) use ($container, $queue) {
				try
				{
					$result = $container->callMethod([$task, 'run']);
					$next();
				}
				catch (Exception $e)
				{
					$queue->buryTask($task);
				}
			});
		}
	}

}
