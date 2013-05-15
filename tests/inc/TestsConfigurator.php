<?php

namespace Tests;

use App;
use \Migration;

/**
 * Konfigurátor, který používá testovaná aplikace i seleniové testy.
 * Upraveno ze Sim realit od Václav Šír.
 *
 * @author Tomáš Sušánka
 */
class TestsConfigurator extends App\Configurator
{

	public function __construct()
	{
		$params = $this->getParams();
		parent::__construct($params['tempDir'], $params);

		$this->onInit['testsNeon'] = function ($configurator) {
				$configurator->addConfig(__DIR__ . '/tests.neon', FALSE);
			};
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
