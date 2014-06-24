<?php

namespace App\Models\Services;

use Latte\Engine;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Object;


class Mailer extends Object
{

	/**
	 * @var \Nette\Mail\IMailer
	 */
	private $mailer;

	public function __construct(IMailer $mailer)
	{
		$this->mailer = $mailer;
	}

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function sendEventRegistration($email, $name)
	{
		$msg = new Message();

		$latte = new Engine();
		$args = [
			'email' => $msg,
		];
		$html = $latte->renderToString($this->getTemplatePath('registration'), $args);

		$msg->setFrom('maraton@khanovaskola.cz', 'Khanova škola')
			->addTo($email, $name)
			->setHtmlBody($html);

		$this->mailer->send($msg);
	}

	protected function getTemplatePath($string)
	{
		return __DIR__ . "/../../templates/emails/$string.latte";
	}

}
