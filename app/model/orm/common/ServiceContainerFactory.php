<?php
namespace App;

use Nette;
use Nette\Caching\Cache;
use Orm;
use DibiConnection;


/**
 * Creates service container for RepositoryContainer.
 *
 * @author Jan Tvrdík
 *
 * @property-read Orm\IServiceContainer $container
 */
class ServiceContainerFactory extends Nette\Object implements Orm\IServiceContainerFactory
{

	/** @var DibiConnection */
	private $dibiConnection;

	/** @var Cache */
	private $cache;

	/**
	 * @param DibiConnection
	 * @param Cache cache for Orm\PerformanceHelper
	 */
	public function __construct(DibiConnection $dibiConnection, Cache $cache)
	{
		$this->dibiConnection = $dibiConnection;
		$this->cache = $cache;
	}

	/**
	 * @return Orm\IServiceContainer
	 */
	public function getContainer()
	{
		$container = new Orm\ServiceContainer();
		$container->addService('annotationsParser', 'Orm\AnnotationsParser');
		$container->addService('annotationClassParser', array($this, 'createAnnotationClassParser'));
		$container->addService('mapperFactory', array($this, 'createMapperFactory'));
		$container->addService('repositoryHelper', 'Orm\RepositoryHelper');
		$container->addService('dibi', $this->dibiConnection);
		$container->addService('performanceHelperCache', $this->cache);

		return $container;
	}

	/**
	 * @internal
	 * @param  Orm\IServiceContainer
	 * @return Orm\IMapperFactory
	 */
	public function createMapperFactory(Orm\IServiceContainer $container)
	{
		return new Orm\MapperFactory($container->getService('annotationClassParser', 'Orm\AnnotationClassParser'));
	}

	/**
	 * @internal
	 * @param  Orm\IServiceContainer
	 * @return Orm\AnnotationClassParser
	 */
	public function createAnnotationClassParser(Orm\IServiceContainer $container)
	{
		return new Orm\AnnotationClassParser($container->getService('annotationsParser', 'Orm\AnnotationsParser'));
	}

}
