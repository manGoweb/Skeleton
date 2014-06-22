<?php

namespace App\Controls;

use Nette\Application\UI\Control as NControl;
use Nette\Bridges\ApplicationLatte\Template;


/**
 * @property-read Template $template
 */
abstract class Control extends NControl
{

	final public function render()
	{
		$this->template->setFile($this->getTemplateFile());
		$this->template->setParameters($this->getArgs());
		$this->template->render();
	}

	protected function getArgs()
	{
		return [];
	}

	protected function getTemplateFile()
	{
		$name = lcFirst($this->getReflection()->getShortName());
		return __DIR__ . "/../templates/controls/$name.latte";
	}

}
