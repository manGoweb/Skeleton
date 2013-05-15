<?php

namespace Tests\Unit;

use Nette;


/**
 * Presenter for testing purposes
 *
 * @author Jan Tvrdík
 */
class TestPresenter extends Nette\Application\UI\Presenter
{

	/** @var bool disable canonicalize() */
	public $autoCanonicalize = FALSE;

	/** @var array # => callback($presenter, $name) */
	public $onCreateComponent = array();

	public function renderDefault()
	{
		$this->terminate();
	}

	protected function createComponent($name)
	{
		$this->onCreateComponent($this, $name);

		if (!isset($this->components[$name]))
		{
			return parent::createComponent($name);
		}
	}

}
