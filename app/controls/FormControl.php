<?php

namespace App\Controls;

use Nette\Reflection\ClassType;


class FormControl extends Control
{

	/**
	 * @var string class
	 */
	private $formClass;

	public function __construct($formClass)
	{
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
