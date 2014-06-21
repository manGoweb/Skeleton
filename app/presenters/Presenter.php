<?php

namespace App\Presenters;

use App\Models\Model;
use Nette\Application\UI\Presenter as NPresenter;


abstract class Presenter extends NPresenter
{

	/**
	 * @var Model
	 * @inject
	 */
	public $model;

}
