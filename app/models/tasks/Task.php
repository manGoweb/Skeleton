<?php

namespace App\Models\Tasks;

use App\ImplementationException;
use Nette\Object;
use Pheanstalk\Job;


/**
 * Tasks must implement method `run` that will be invoked
 * with Container, meaning you can specify whatever dependencies
 * you need easily.
 * <code>
 * public function run(RepositoryContainer $repo, Mailer $mailer) {}
 * </code>
 */
abstract class Task extends Object
{

	/** @var Job */
	private $job;

	public function __construct()
	{
		if (!method_exists($this, 'run'))
		{
			$class = get_class($this);
			throw new ImplementationException("Task '$class' does not implement required method 'run'.");
		}
	}

	public function setJob(Job $job)
	{
		$this->job = $job;
	}

	public function getJob()
	{
		return $this->job;
	}

}
