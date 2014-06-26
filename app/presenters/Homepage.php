<?php

namespace App\Presenters;


class Homepage extends Presenter
{

	public function renderDefault()
	{
		$this->template->add('version', (object) [
			'nette' => \Nette\Framework::VERSION,
			'porm' => \Orm\Orm::VERSION,
			'php' => PHP_VERSION,
			'server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : NULL,
		]);
	}

}
