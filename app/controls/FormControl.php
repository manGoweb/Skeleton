<?php

namespace App\Controls;

use App\InvalidArgumentException;
use Nette\Reflection\ClassType;


/**
 * Wraps forms and sets template path. Allows custom form rendering.
 *
 * Forms under App\Controls\Forms namespace do not need factories in Presenter
 * as they are invoked dynamically by requesting `FooForm` control.
 *
 * Example:
 *  Requesting {control fooForm} creates new FormControl with App\Controls\Forms\Foo class
 */
class FormControl extends Control
{

	/**
	 * @var string class
	 */
	private $formClass;

	public function __construct($formClass)
	{
		if (!class_exists($formClass))
		{
			throw new InvalidArgumentException("Class $formClass does not exist.");
		}
		parent::__construct();

		$this->formClass = $formClass;
	}

	public function createComponentForm()
	{
		return new $this->formClass;
	}

	protected function renderDefault()
	{
		$this->template->add('form', $this['form']);
	}

	protected function getTemplateFile($view = NULL)
	{
		$name = lcFirst(ClassType::from($this->formClass)->getShortName());
		return __DIR__ . "/../templates/controls/forms/$name.latte";
	}

}
