<?php

namespace App;

use Clevispace;


/**
 * Base presenter for all application presenters.
 *
 * @property-read RepositoryContainer $orm
 */
abstract class BasePresenter extends Clevispace\BasePresenter
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
