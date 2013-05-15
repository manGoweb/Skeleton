<?php

namespace App\Migration\Extensions;

use App;
use Migration;
use Nette;
use DibiConnection;


/**
 * @author Petr Procházka
 */
class OrmPhp extends Migration\Extensions\SimplePhp
{

	private $orm;

	public function __construct(App\Configurator $configurator, Nette\DI\Container $context, DibiConnection $dibi)
	{
		parent::__construct();
		$this->addParameter('createOrm', function () use ($configurator, $context, $dibi) {
			$orm = $configurator->createServiceOrm($context);
			$orm->getContext()
				->removeService('performanceHelperCache')
				->removeService('dibiConnection')
				->addService('dibiConnection', $dibi)
			;
			return $orm;
		});
		$this->addParameter('context', $context);
		$this->addParameter('dibi', $dibi);
	}

	public function getParameters()
	{
		$parameters = parent::getParameters();
		if ($this->orm) $this->orm->flush();
		$this->orm = $parameters['createOrm']();
		$parameters['orm'] = $this->orm;
		return $parameters;
	}

	public function getName()
	{
		return 'orm.php';
	}

	public function execute(Migration\File $sql)
	{
		parent::execute($sql);
		$this->orm->flush();
		$this->orm = NULL;
	}
}
