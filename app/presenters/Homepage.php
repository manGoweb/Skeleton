<?php

namespace App\Presenters;

use App\Models\Services\Mailer;


class Homepage extends Presenter
{

	/**
	 * @var Mailer @inject
	 */
	public $mailer;

	public function renderDefault()
	{
		$this->mailer->sendEventRegistration('rullaf@gmail.com', 'Mikuláš Dítě');

		$marathon = $this->model->marathons->getLatest();

		$this->template->marathon = $marathon;
	}

}
