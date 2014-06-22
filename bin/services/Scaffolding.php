<?php

namespace Bin\Services;

use Inflect\Inflect;
use Latte\Engine;
use Nette\Object;


class Scaffolding extends Object
{

	/**
	 * @var string path
	 */
	protected $appDir;

	public function __construct($appDir)
	{
		$this->appDir = $appDir;
	}

	public function createEntity($singularName, array $params)
	{
		$pluralName = Inflect::pluralize($singularName);
		$path = $this->getRmePath($pluralName) . "/$singularName.php";
		$this->buildFromTemplate($path, 'rme_entity', [
			'class' => $singularName,
			'properties' => $params,
		]);
	}

	public function createRepository($singularName)
	{
		$name = Inflect::pluralize($singularName);
		$class = "{$name}Repository";
		$path =  $this->getRmePath($name) . "/$class.php";
		$this->buildFromTemplate($path, 'rme_repository', [
			'class' => $class,
		]);
	}

	public function createMapper($singularName)
	{
		$name = Inflect::pluralize($singularName);
		$class = "{$name}Mapper";
		$path =  $this->getRmePath($name) . "/$class.php";
		$this->buildFromTemplate($path, 'rme_mapper', [
			'class' => $class,
		]);
	}

	protected function buildFromTemplate($file, $template, $args = [])
	{
		$dir = dirname($file);
		if (!is_dir($dir))
		{
			mkdir($dir);
		}

		$latte = new Engine();
		$content = "<?php\n\n" . $latte->renderToString(__DIR__ . "/../scaffolds/$template.latte", $args);
		file_put_contents($file, $content);
	}

	protected function getRmePath($pluralName)
	{
		return "$this->appDir/models/rme/$pluralName";
	}

}
