<?php

namespace Tests\Selenium;

use Clevispace\TemplateFactory;
use Nette\Application\UI\Control;

/**
 * @author Tomáš Sušánka
 */
class SeleniumTemplateFactory extends TemplateFactory
{

	public function createTemplate($file = NULL, Control $control = NULL)
	{
		$template = parent::createTemplate($file, $control);
		$template->basePath = $template->basePath . '/../../www';

		return $template;
	}
}
