<?php

namespace App\Presenters;


class Homepage extends Presenter
{

	public function actionDefault()
	{
		$this->flashInfo('Ano nevim?', 'Super long message, lorem ipsum dolor met sit amet.');
		$this->flashSuccess('Dalsi nevim.', 'Super long message, lorem ipsum dolor met sit amet.');
		$this->flashWarning('Warng nevim!', 'Super long message, lorem ipsum dolor met sit amet.');
		$this->flashError('Fail nevim!', 'Super long message, lorem ipsum dolor met sit amet.');
	}

}
