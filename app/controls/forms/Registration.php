<?php

namespace App\Controls\Forms;


class Registration extends Form
{

	public function setup()
	{
		$this->addText('email')
			->setRequired()
			->addRule($this::EMAIL);
		$this->addText('name')
			->setRequired();

		$this->addSubmit();
	}

	public function onSuccess()
	{
		dump($this->values);
	}

}
