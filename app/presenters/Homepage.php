<?php

namespace App\Presenters;


class Homepage extends Presenter
{

	public function renderDefault()
	{
		$marathon = $this->model->marathons->getLatest();

		$this->template->marathon = $marathon;
	}

}
