<?php

namespace Clevis\Skeleton;

use Nette;
use StdClass;
use App\RepositoryContainer;


/**
 * Base presenter for all application presenters.
 *
 * @property-read RepositoryContainer $orm
 * @property StdClass $template
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * Returns RepositoryContainer.
	 *
	 * @author Jan Tvrdík
	 * @return RepositoryContainer
	 */
	public function getOrm()
	{
		return $this->context->getService('repositoryContainer');
	}

	/**
	 * Creates configured template.
	 *
	 * @author Jan Tvrdík
	 * @return Nette\Templating\ITemplate
	 */
	protected function createTemplate($class = NULL)
	{
		if ($class !== NULL)
		{
			throw new \Nette\NotImplementedException('Specifying template class is not yet implemented.');
		}

		return $this->context->getService('templateFactory')->createTemplate(NULL, $this);
	}

	/**
	 * Formats template file names
	 *
	 * Support for templates installed from skeleton package
	 *
	 * @return array
	 */
	public function formatTemplateFiles()
	{
		$params = $this->context->getParameters();
		$name = $this->getName();
		$presenter = substr($name, strrpos(':' . $name, ':'));
		$dir = dirname($params['appDir'] . '/' . preg_replace('/(([^:]):)/', '\2Module/', $name));

		$dir = is_dir("$dir/templates") ? $dir : dirname($dir);
		$files = array(
			"$dir/templates/$presenter/$this->view.latte",
			"$dir/templates/$presenter/package/$this->view.latte",
		);

		return $files + parent::formatTemplateFiles();
	}

}
