<?php

namespace App\Presenters;


class Homepage extends Presenter
{

	public function renderDefault()
	{
		$venue = $this->model->venues->getById(1);
		$this->template->venue = $venue;
	}

}
