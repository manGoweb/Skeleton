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
		$this->addPassword('validation')
			->setRequired()
			->addConditionOn($this['password'], $this::EQUAL);

		$this->addSubmit();
	}

}
