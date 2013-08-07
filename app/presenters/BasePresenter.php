<?php

namespace Clevis\Skeleton;

use Nette;
use StdClass;
use App\RepositoryContainer;
use Clevis\Skeleton\Core;


/**
 * Base presenter for all application presenters
 *
 * @property-read RepositoryContainer $orm
 * @property StdClass $template
 */
abstract class BasePresenter extends Core\BasePresenter
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
