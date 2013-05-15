<?php

namespace Tests\Selenium;

use Se34\TestCase;
use SystemContainer;
use Tests\MigrationsLoader;


/**
 * Základní třída pro seleniové testy projektu.
 *
 * @property-read Features\Authentication $auth Přihlašovadlo-odhlašovadlo.
 * @author Václav Šír
 * @author Tomáš Sušánka
 */
abstract class SeleniumTestCase extends TestCase
{
	/** @var Features\Authentication */
	private $auth;

	/** @var SystemContainer */
	private $context;

	/**
	 * Vezme si container z globální proměnné v boot.php a zavolá migrace.
	 * @return SystemContainer
	 */
	protected function createContext()
	{
		$this->context = $GLOBALS['diContainer'];

		if (!isset($this->context->parameters['testDbName']))
		{
			$migrator = new MigrationsLoader($this->context);
			$migrator->runMigrations();
		}

		if (!isset($this->context->parameters['selenium']['baseUrl']))
		{
			$url = $this->context->httpRequest->url;
			$baseUrl = $url->getHostUrl() . dirname($url->getPath()) . '/tests/test-www/';
			$this->context->parameters['selenium']['baseUrl'] = $baseUrl;
		}
		return $this->context;
	}

	/**
	 * Přihlašovadlo-odhlašovadlo.
	 * @return Features\Authentication
	 */
	public function getAuth()
	{
		if (!isset($this->auth))
		{
			$this->auth = new Features\Authentication($this->session);
		}
		return $this->auth;
	}

	/**
	 * Smaže DB, pokud řečeno v configu.
	 */
	protected function tearDown()
	{
		parent::tearDown();
		$this->auth = NULL;

		if (!$this->context->parameters['migrations']['enabled']) return;

		$dropDb = ($this->getStatus() === \PHPUnit_Runner_BaseTestRunner::STATUS_PASSED)
			? $this->context->parameters['migrations']['dropDatabaseOnSuccess']
			: $this->context->parameters['migrations']['dropDatabaseOnFailure'];

		if ($dropDb)
		{
			$this->context->dibiConnection->query('DROP DATABASE IF EXISTS %n', $this->context->parameters['testDbName']);
			$this->context->parameters['testDbName'] = NULL;
		}
	}

}
