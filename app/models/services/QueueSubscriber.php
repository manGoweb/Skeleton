<?php

namespace App\Models\Services;

use App\Models\Tasks\Task;
use Nette\Object;
use ZMQSocket;
use ZMQSocketException;


class QueueSubscriber extends Object
{

	/**
	 * @var ZMQSocket
	 */
	protected $sub;

	public function __construct(ZMQSocket $sub)
	{
		$this->sub = $sub;
	}

	/**
	 * @param callable $process(Task)
	 * @throws ZMQSocketException
	 */
	public function pop(callable $process)
	{
		$message = $this->sub->recv();
		/** @var Task $task */
		$task = unserialize($message);

		$process($task);
	}

}
