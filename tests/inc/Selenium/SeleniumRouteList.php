<?php

namespace Tests\Selenium;

use App\Router;
use Nette\Application\Request;
use Nette\Http\Url;
use Nette\DI\Container;

/**
 * RouteList, který ke každé generované URL přidává parametr testDbName.
 * Upraveno ze Sim realit od Václav Šír.
 *
 * @author Tomáš Sušánka
 */
class SeleniumRouteList extends Router
{

	/** @var \Nette\DI\Container */
	private $container;

	/**
	 * @param Container $container Kvůli předávání testDbName
	 * @param string $urlReplaceSearch První argument str_replace() nad URL při match().
	 * @param string $urlReplaceReplace Druhý argument str_replace() nad URL při match().
	 */
	function __construct(Container $container)
	{
		parent::__construct($container);
		$this->container = $container;
	}

	/**
	 * @param Request $appRequest
	 * @param Url $refUrl
	 * @return string
	 */
	public function constructUrl(Request $appRequest, Url $refUrl)
	{
		if (!$this->container->parameters['testDbName'])
		{
			parent::constructUrl($appRequest, $refUrl);
		}

		$appRequest = clone $appRequest;
		$params = $appRequest->parameters;
		$params['testDbName'] = $this->container->parameters['testDbName'];
		$appRequest->parameters = $params;
		return parent::constructUrl($appRequest, $refUrl);
	}

}
