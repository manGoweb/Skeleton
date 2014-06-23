<?php

namespace App\Presenters;

use App\Controls\FormControl;
use App\Models\Model;
use Nette\Application\UI\Presenter as NPresenter;


abstract class Presenter extends NPresenter
{

	const FLASH_INFO = 'info';
	const FLASH_SUCCESS = 'success';
	const FLASH_WARNING = 'warning';
	const FLASH_ERROR = 'danger';


	/**
	 * @var Model
	 * @inject
	 */
	public $model;

	protected function createComponent($name)
	{
		if (substr($name, -4) === 'Form')
		{
			$formClass = 'App\\Controls\\Forms\\' . ucFirst(substr($name, 0, -4));
			if (class_exists($formClass))
			{
				return new FormControl($formClass);
			}
		}
		else
		{
			$controlClass = 'App\\Controls\\' . ucFirst($name);
			if (class_exists($controlClass))
			{
				return new $controlClass;
			}
		}
		return parent::createComponent($name);
	}

	public function flashInfo($headline, $message)
	{
		$this->flashMessage($headline, $message, self::FLASH_INFO);
	}

	public function flashSuccess($headline, $message)
	{
		$this->flashMessage($headline, $message, self::FLASH_SUCCESS);
	}

	public function flashWarning($headline, $message)
	{
		$this->flashMessage($headline, $message, self::FLASH_WARNING);
	}

	public function flashError($headline, $message)
	{
		$this->flashMessage($headline, $message, self::FLASH_ERROR);
	}

	/**
	 * @param string $headline
	 * @param NULL|string $message
	 * @param NULL|string $type
	 * @return \stdClass
	 */
	public function flashMessage($headline, $message = NULL, $type = self::FLASH_INFO)
	{
		$id = $this->getParameterId('flash');
		$messages = $this->getFlashSession()->$id;
		$messages[] = $flash = (object) [
			'headline' => $headline,
			'message' => $message,
			'type' => $type,
		];
		$this->template->flashes = $messages;
		$this->getFlashSession()->$id = $messages;
		return $flash;
	}

}
