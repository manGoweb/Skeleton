<?php

namespace App\Models\Services;

use Exception;
use Latte\Engine;
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
	 * @throws Exception
	 */
	public function sendEventRegistration($email, $name)
	{
		$msg = new Message();

		$latte = new Engine();
		$args = [
			'email' => $msg,
		];
		$html = $latte->renderToString($this->getTemplatePath('registration'), $args);

		$msg->setFrom('youshould@probablychange.this', 'Nazev Appky')
			->addTo($email, $name)
			->setHtmlBody($html);

		$this->mailer->send($msg);
	}

	protected function getTemplatePath($string)
	{
		return __DIR__ . "/../../templates/emails/$string.latte";
	}

}
