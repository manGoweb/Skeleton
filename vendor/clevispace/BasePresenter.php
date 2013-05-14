<?php

namespace Clevispace;

use Nette;


/**
 * Base class for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

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
			throw new \NotImplementedException('Specifying template class is not yet implemented.');
		}

		return $this->context->getService('templateFactory')->createTemplate(NULL, $this);
	}

}
