<?php

namespace App;

use Orm;


/**
 * Formátuje jména tabulek
 */
class SqlConventional extends Orm\SqlConventional
{

	/** @var string[] */
	private $tableCache = array();


	/**
	 * Formátuje jména tabulek (slova oddělená podtržítky, lowercase)
	 * @param Orm\IRepository
	 * @return string
	 */
	public function getTable(Orm\IRepository $repository)
	{
		$class = get_class($repository);
		if (!isset($this->tableCache[$class]))
		{
			// odstraňujeme namespace + poslední lomítko a pak slovo "Repository"
			$this->tableCache[$class] = strtolower(
				preg_replace('/([A-Z]+)([A-Z])/','\1_\2',
					preg_replace('/([a-z\d])([A-Z])/','\1_\2',
						substr($class, strlen(__NAMESPACE__) + 1, - strlen('Repository')))));
		}
		return $this->tableCache[$class];
	}

}
