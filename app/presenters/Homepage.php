<?php

namespace App\Presenters;

use App\Models\Services\Mailer;
use App\Models\Tasks\SendRegistrationEmail;


class Homepage extends Presenter
{

	public function renderDefault()
	{
		$this->queue->enqueue(new SendRegistrationEmail('rullaf@gmail.com', 'Mikuláš Dítě'));

		$marathon = $this->model->marathons->getLatest();

		$this->template->marathon = $marathon;
	}

}
