<?php

namespace App\Controls\Forms;


class Registration extends Form
{

	public function setup()
	{
		$this->addText('email')
			->setRequired()
			->addRule($this::EMAIL);
		$this->addPassword('password')
			->setRequired();

		$this->addSubmit();
	}

	public function onSuccess()
	{
		dump($this->values);
	}

}
