<?php

namespace App\Models\Tasks;

use App\InvalidArgumentException;
use App\Models\Services\Mailer;
use Nette\Utils\Validators;


class SendRegistrationEmail extends SendEmail
{

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function __construct($email, $name)
	{
		if (!Validators::isEmail($email))
		{
			throw new InvalidArgumentException;
		}
		$this->email = $email;
		$this->name = $name;
	}

	public function run(Mailer $mailer)
	{
		$mailer->sendEventRegistration($this->email, $this->name);
	}

}
