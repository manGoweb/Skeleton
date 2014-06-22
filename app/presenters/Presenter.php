<?php

namespace App\Presenters;

use App\Controls\FormControl;
use App\Models\Model;
use Nette\Application\UI\Presenter as NPresenter;


abstract class Presenter extends NPresenter
{

	/**
	 * @var Model
	 * @inject
	 */
	public $model;

	protected function createComponent($name)
	{
		if (substr($name, -4) === 'Form')
		{
			$formClass = 'App\\Controls\\Forms\\' . ucFirst(substr($name, 0, -4));
			if (class_exists($formClass))
			{
				return new FormControl($formClass);
			}
		}
		else
		{
			$controlClass = 'App\\Controls\\' . ucFirst($name);
			if (class_exists($controlClass))
			{
				return new $controlClass;
			}
		}
		return parent::createComponent($name);
	}

}
