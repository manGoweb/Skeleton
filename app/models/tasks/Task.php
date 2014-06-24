<?php

namespace App\Models\Tasks;

use Nette\Object;
use Pheanstalk\Job;


abstract class Task extends Object
{

	/** @var Job */
	private $job;

	// TODO check run is implemented

	public function setJob(Job $job)
	{
		$this->job = $job;
	}

	public function getJob()
	{
		return $this->job;
	}

}
