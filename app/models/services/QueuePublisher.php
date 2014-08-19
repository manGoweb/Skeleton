<?php

namespace App\Models\Services;

use App\Models\Tasks\Task;
use Nette\Object;
use ZMQSocket;
use ZMQSocketException;


class QueuePublisher extends Object
{

	/**
	 * @var ZMQSocket
	 */
	protected $pub;

	/**
	 * @var ZMQSocket
	 */
	protected $sub;

	public function __construct(ZMQSocket $pub)
	{
		$this->pub = $pub;
	}

	/**
	 * @param Task $task
	 * @throws ZMQSocketException
	 */
	public function enqueue(Task $task)
	{
		$this->pub->send(serialize($task));
	}

}
