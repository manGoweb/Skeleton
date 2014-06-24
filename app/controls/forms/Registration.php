<?php

namespace App\Controls\Forms;

use App\Models\Services\Mailer;
use App\Models\Services\Queue;
use App\Models\Tasks\SendRegistrationEmail;
use Nette;


class Registration extends Form
{

	/**
	 * @var \App\Models\Services\Queue
	 */
	private $queue;

	public function __construct(Queue $queue)
	{
		parent::__construct();
		$this->queue = $queue;
	}

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
		$this->queue->enqueue(new SendRegistrationEmail($this['email']->value, $this['name']->value));
		$this->presenter->flashInfo('Super!', 'Těšíme se na tebe.');
		$this->presenter->redirect('this');
	}

}
