<?php

namespace App\Models\Services;

use App\InvalidStateException;
use App\Models\Tasks\Task;
use Nette\Object;
use Pheanstalk\Connection;
use Pheanstalk\Pheanstalk;


class Queue extends Object
{

	/** @var Pheanstalk */
	private $stalk;

	/** @var string url */
	private $host;

	/** @var string */
	private $tubeId;

	public function __construct($host, $tubeId)
	{
		$this->stalk = new Pheanstalk($host);
		$this->host = $host;
		$this->tubeId = $tubeId;
	}

	protected function assertConnected()
	{
		/** @var Connection $conn */
		$conn = $this->stalk->getConnection();
		if (!$conn->isServiceListening())
		{
			throw new InvalidStateException("Beanstalkd is not running on '$this->host'");
		}
	}

	public function enqueue(Task $task)
	{
		$this->assertConnected();

		$this->stalk
			->useTube($this->tubeId)
			->put(serialize($task));
	}

	public function watch($cb)
	{
		$this->assertConnected();
		$job = $this->stalk
			->watch($this->tubeId)
			->ignore('default')
			->reserve();

		/** @var Task $task */
		$task = unserialize($job->getData());
		$task->setJob($job);

		$cb($task, function() use ($job) {
			$this->stalk->delete($job);
		}, $job);
	}

	/**
	 * Remove (presumably failing) task from queue
	 * @param Task $task
	 */
	public function buryTask(Task $task)
	{
		$this->stalk->bury($task->getJob());
	}

}
