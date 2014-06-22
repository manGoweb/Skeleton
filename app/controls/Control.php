<?php

namespace App\Controls;

use App\ImplementationException;
use Nette\Application\UI\Control as NControl;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\ComponentModel\IContainer;
use Nette\Reflection\Method;


/**
 * Unlike NControl this class has support for custom rendering methods
 * that automatically set template file.
 * - `renderDefault` is invoked by both {control foo} and {control foo:default}
 * - `renderBar` is invoked by {control foo:bar}
 * - `render` method handles the method magic and should never be called directly.
 * Render* methods must be declared as protected, otherwise the render method will
 * never be called. This is enforced in constructor.
 *
 * Controls under App\Controls namespace do not need factories in Presenter
 * as they are invoked dynamically.
 *
 * @property-read Template $template
 */
abstract class Control extends NControl
{

	public function __construct(IContainer $parent = NULL, $name = NULL)
	{
		parent::__construct($parent, $name);

		foreach ($this->getReflection()->getMethods(Method::IS_PUBLIC) as $method)
		{
			$m = $method->getShortName();
			if ($m !== 'render' && strpos($m, 'render') === 0)
			{
				$class = get_class($this);
				throw new ImplementationException("Method '$class::$m' must have protected visibility.");
			}
		}
	}

	final public function render($view = 'default')
	{
		$this->template->setFile($this->getTemplateFile($view));

		$method = "render$view";
		if (method_exists($this, $method))
		{
			$this->$method();
		}

		$this->template->render();
	}

	public function __call($name, $args)
	{
		if (strpos($name, 'render') !== 0)
		{
			return parent::__call($name, $args);
		}

		$this->render(lcFirst(substr($name, 6)));
		return NULL;
	}

	protected function getTemplateFile($view = NULL)
	{
		$name = lcFirst($this->getReflection()->getShortName());
		if ($view && $view !== 'default')
		{
			$name .= ".$view";
		}
		return __DIR__ . "/../templates/controls/$name.latte";
	}

}
