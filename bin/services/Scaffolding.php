<?php

namespace Bin\Services;

use App\InvalidStateException;
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
		return $path;
	}

	public function createRepository($singularName)
	{
		$name = Inflect::pluralize($singularName);
		$class = "{$name}Repository";
		$path =  $this->getRmePath($name) . "/$class.php";
		$this->buildFromTemplate($path, 'rme_repository', [
			'class' => $class,
		]);
		return $path;
	}

	public function createMapper($singularName)
	{
		$name = Inflect::pluralize($singularName);
		$class = "{$name}Mapper";
		$path =  $this->getRmePath($name) . "/$class.php";
		$this->buildFromTemplate($path, 'rme_mapper', [
			'class' => $class,
		]);
		return $path;
	}

	protected function buildFromTemplate($file, $template, $args = [])
	{
		if (is_file($file))
		{
			throw new InvalidStateException("File '$file' already exists");
		}

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

	protected function getUnitTestPath()
	{
		return "$this->appDir/../tests/cases/unit";
	}

	public function createUnitTest($name)
	{
		$name = ucFirst($name);
		$class = "{$name}Test";
		$path =  $this->getUnitTestPath() . "/$class.phpt";
		$this->buildFromTemplate($path, 'test_unit', [
			'class' => $class,
		]);
		return $path;
	}

}
