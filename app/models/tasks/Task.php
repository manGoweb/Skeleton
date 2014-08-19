<?php

namespace App\Models\Tasks;

use App\ImplementationException;
use Nette\Object;


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
	public function __construct()
	{
		if (!method_exists($this, 'run'))
		{
			$class = get_class($this);
			throw new ImplementationException("Task '$class' does not implement required method 'run'.");
		}
	}

}
