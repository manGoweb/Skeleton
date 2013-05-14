<?php

namespace Clevispace;

use Nette;


/**
 * Base control for all application controls
 */
abstract class BaseControl extends Nette\Application\UI\Control
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

		return $this->getPresenter()->getService('templateFactory')->createTemplate(NULL, $this);
	}

}
