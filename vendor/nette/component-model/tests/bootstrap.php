<?php

// The Nette Tester command-line runner can be
// invoked through the command: ../vendor/bin/tester .

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}


Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');


class Notes
{
	static public $notes = array();

	public static function add($message)
	{
		self::$notes[] = $message;
	}

	public static function fetch()
	{
		$res = self::$notes;
		self::$notes = array();
		return $res;
	}

}