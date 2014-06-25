<?php

namespace App\Controls\Forms;

use App\Models\Orm\Model;
use App\Models\Rme\User;
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

	/**
	 * @var \App\Models\Orm\Model
	 */
	private $model;

	public function __construct(Queue $queue, Model $model)
	{
		parent::__construct();
		$this->queue = $queue;
		$this->model = $model;
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
		$v = $this->values;

		$user = new User($v->email, $v->name);
		$this->model->users->persistAndFlush($user);

//		 TODO add token

		$this->queue->enqueue(new SendRegistrationEmail($v->email, $v->name));
		$this->presenter->flashInfo('Super!', 'Těšíme se na tebe.');
		$this->presenter->redirect('this');
	}

}
