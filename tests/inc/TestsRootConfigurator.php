<?php

namespace Tests;

use App;
use Migration;
use SystemContainer;


/**
 * Konfigurátor, který používá root pro testování - tj. test-www/
 *
 * @author Tomáš Sušánka
 */
class TestsRootConfigurator extends App\Configurator
{

	/**
	 * @var string Název používané databáze
	 */
	private $testDbName;

	/**
	 * @param string $testDbName Název používané databáze
	 */
	public function __construct($testDbName = NULL)
	{
		$params = $this->getParams();
		parent::__construct($params['tempDir'], $params);
		$this->testDbName = $testDbName;

		$this->onInit['testsNeon'] = function ($configurator) {
				$configurator->addConfig(__DIR__ . '/tests.neon', FALSE);
			};
	}

	/**
	 * Vytvoří systémový kontejner a vytvoří testovací databázi.
	 *
	 * @return SystemContainer
	 */
	public function createContainer()
	{
		$container = parent::createContainer();
		if ($this->testDbName)
		{
			$container->dibiConnection->query('USE %n', $this->testDbName);
			$container->parameters['testDbName'] = $container->parameters['database']['database'] = $this->testDbName;
		}
		return $container;
	}

	/**
	 * Poupraví parametry pro testy, kvůli jinému rootu.
	 *
	 * @author Tomáš Sušánka
	 */
	protected function getParams()
	{
		$params = parent::getDefaultParameters();
		$params['appDir'] = realpath(__DIR__ . '/../../app');
		$params['testWwwDir'] = $params['appDir'] . '/../tests/test-www';
		$params['wwwDir'] = $params['appDir'] . '/../www';
		$params['tempDir'] = $params['testWwwDir'] . '/tmp';
		return $params;
	}

}
