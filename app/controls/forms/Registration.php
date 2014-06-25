<?php

namespace App\Controls\Forms;

use App\Models\Orm\Model;
use App\Models\Rme\Attendee;
use App\Models\Services\Queue;
use App\Models\Tasks\SendRegistrationEmail;
use Nette;
use PDOException;


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

		$att = $this->model->attendees->getByEmail($v->email);
		if (!$att)
		{
			$att = new Attendee($v->email, $v->name);
			$this->model->attendees->persist($att);
		}
		$att->marathons->add($this->model->marathons->getLatest());

		try
		{
			$att->marathons->persist();
			$this->model->marathons->flush();
		}
		catch (PDOException $e)
		{
			if ($e->getCode() != 23000)
			{
				throw $e;
			}

			// TODO print when user registered
			$this->presenter->flashInfo('To je ale nadšení!', 'Na tenhle maraton už jsi se zaregistroval. Počítáme s tebou!');
			$this->presenter->redirect('this');
		}

		$this->queue->enqueue(new SendRegistrationEmail($v->email, $v->name));
		$this->presenter->flashInfo('Super!', 'Těšíme se na tebe.');
		$this->presenter->redirect('this');
	}

}
