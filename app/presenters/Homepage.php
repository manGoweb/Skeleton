<?php

namespace App\Presenters;

use App\Models\Tasks\SendRegistrationEmail;


class Homepage extends Presenter
{

	public function renderDefault()
	{
		$marathon = $this->model->marathons->getLatest();

		$this->template->marathon = $marathon;
	}

}
