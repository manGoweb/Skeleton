<?php

namespace App\Controls\Forms;

use Nette;
use Nette\Application\UI\Form as NForm;


/**
 * Differences to NForm
 * - addSubmit name is optional
 */
abstract class Form extends NForm
{

	/**
	 * @param NULL|string $name
	 * @param NULL|string $caption
	 * @return \Nette\Forms\Controls\SubmitButton
	 */
	public function addSubmit($name = NULL, $caption = NULL)
	{
		return parent::addSubmit($name ?: 'save', $caption);
	}

}
