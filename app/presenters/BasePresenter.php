<?php

namespace App;

use Clevis\Skeleton;


/**
 * Base presenter for all application presenters.
 *
 * @property-read RepositoryContainer $orm
 */
abstract class BasePresenter extends Skeleton\BasePresenter
{

	/**
	 * Returns RepositoryContainer.
	 *
	 * @author Jan Tvrdík
	 * @return RepositoryContainer
	 */
	public function getOrm()
	{
		return $this->context->getService('repositoryContainer');
	}

}
