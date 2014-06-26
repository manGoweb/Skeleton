<?php

namespace App\Presenters;


class Homepage extends Presenter
{

	public function actionDefault()
	{
		dump($this->repos);
		dump($this->repos->articles);
	}

}
