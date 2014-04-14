<?php

namespace App;

use Clevis\Skeleton\BasePresenter;
use Nette;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
