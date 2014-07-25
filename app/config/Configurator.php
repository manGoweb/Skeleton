<?php

namespace App\Config;

use Bin\Support\VariadicArgvInput;
use Nette;
use Nette\DI;
use Nette\FileNotFoundException;
use Nette\Loaders\RobotLoader;
use RuntimeException;
use SystemContainer;
use Tracy\Debugger;


/**
 * @method void onInit
 * @method void onAfter
 */
class Configurator extends Nette\Configurator
{

	/** @var array of function(Configurator $sender); Occurs before first Container is created */
	public $onInit = [];

	/** @var array of function(Configurator $sender); Occurs after first Container is created */
	public $onAfter = [];


	/**
	 * @param string|NULL null mean autodetect
	 * @param array|NULL $params
	 */
	public function __construct(array $params = NULL)
	{
		parent::__construct();

		$root = __DIR__ . '/../..';

		$this->setTempDirectory(realpath("$root/temp"));
		$this->addParameters((array) $params + array_map('realpath', [
			'appDir' => "$root/app",
			'binDir' => "$root/bin",
			'libsDir' => "$root/vendor",
			'wwwDir' => "$root/www",
		]));

		foreach (get_class_methods($this) as $name)
		{
			if ($pos = strpos($name, 'onInit') === 0 && $name !== 'onInitPackages')
			{
				$this->onInit[lcfirst(substr($name, $pos + 5))] = [$this, $name];
			}
		}

		foreach (get_class_methods($this) as $name)
		{
			if ($pos = strpos($name, 'onAfter') === 0)
			{
				$this->onAfter[lcfirst(substr($name, $pos + 5))] = [$this, $name];
			}
		}

		$this->enableDebugger("$root/log");

		$this->createRobotLoader()->register();
	}

	public function onInitConfigs()
	{
		$params = $this->getParameters();
		foreach (['system', 'bin', 'config', 'config.local'] as $config)
		{
			$this->addConfig($params['appDir'] . "/config/$config.neon", FALSE);
		}
	}

	public function onAfterDebug(SystemContainer $c)
	{
		$p = $c->parameters;
		if (isset($p['forceDebug']))
		{
			$mode = $p['forceDebug'] === FALSE
				? Debugger::PRODUCTION
				: Debugger::DEVELOPMENT;
			Debugger::enable($mode);
		}
	}

	public function onAfterConsole($c)
	{
		/** @var SystemContainer $c */
		$s = 'console.router';
		if ($c->hasService($s))
		{
			$c->getService($s)->setInput(new VariadicArgvInput());
		}
	}

	/**
	 * @return RobotLoader
	 */
	public function createRobotLoader()
	{
		$params = $this->getParameters();
		$loader = parent::createRobotLoader();
		$loader->addDirectory($params['appDir']);

		// TODO only add when bin is called
		$loader->addDirectory($params['binDir']);

		// TODO only add when tests are run
		$loader->addDirectory($params['appDir'] . '/../tests');

		// TODO only add when migrations are run
		$loader->addDirectory($params['appDir'] . '/../migrations');

		return $loader;
	}

	/**
	 * @return array
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * @throws MissingLocalConfigException
	 * @throws \Exception
	 * @throws \Nette\FileNotFoundException
	 * @return SystemContainer
	 */
	public function createContainer()
	{
		$this->onInit($this);
		$this->onInit = [];

		try {
			$container = parent::createContainer();
			$this->onAfter($container);

			return $container;
		}
		catch (FileNotFoundException $e)
		{
			if (strpos($e->getMessage(), 'local') !== FALSE)
			{
				throw new MissingLocalConfigException($e);
			}
			else
			{
				throw $e;
			}
		}
	}

}


class MissingLocalConfigException extends RuntimeException
{

	/**
	 * @param \Nette\FileNotFoundException $e
	 */
	public function __construct(FileNotFoundException $e)
	{
		parent::__construct('Copy "app/config/config.local.example.neon" to "app/config/config.local.neon" and update credentials.', NULL, $e);
	}

}
