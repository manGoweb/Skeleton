<?php

namespace Clevis\Skeleton;

use Nette;
use StdClass;
use App\RepositoryContainer;


/**
 * Base presenter for all application presenters.
 *
 * @property-read RepositoryContainer $orm
 * @property StdClass $template
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
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

	/**
	 * Creates configured template.
	 *
	 * @author Jan Tvrdík
	 * @return Nette\Templating\ITemplate
	 */
	protected function createTemplate($class = NULL)
	{
		if ($class !== NULL)
		{
			throw new \Nette\NotImplementedException('Specifying template class is not yet implemented.');
		}

		return $this->context->getService('templateFactory')->createTemplate(NULL, $this);
	}

}
