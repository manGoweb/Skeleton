<?php

namespace Clevispace;

use Nette;
use Nette\Application\UI;
use Nette\Caching;
use Nette\FileNotFoundException;
use Nette\Localization\ITranslator;
use Nette\Templating\FileTemplate;


/**
 * Templates factory. Used to create templates in both presenters and components.
 *
 * @author Jan Tvrdík
 * @author Petr Procházka
 */
class TemplateFactory extends Nette\Object
{

	/** @var Caching\IStorage */
	private $cacheStorage;

	/** @var callable return FileTemplate */
	private $createTemplate;

	/** @var ITranslator|NULL */
	private $translator;



	/**
	 * @param  Caching\IStorage cache storage for templates
	 * @param  callable return FileTemplate
	 * @param  ITranslator|NULL
	 */
	public function __construct(Caching\IStorage $cacheStorage, $createTemplate, ITranslator $translator = NULL)
	{
		$this->cacheStorage = $cacheStorage;
		$this->createTemplate = $createTemplate;
		$this->translator = $translator;
	}



	/**
	 * Creates and configures template.
	 *
	 * Mostly based on {@link Nette\Application\UI\Control::createTemplate()}.
	 *
	 * @param  string path to template
	 * @param  UI\Control control which will be available in $tpl->control
	 * @return FileTemplate
	 * @throws FileNotFoundException if template does not exist
	 */
	public function createTemplate($file, UI\Control $control = NULL)
	{
		$template = call_user_func($this->createTemplate);
		$template->setCacheStorage($this->cacheStorage);
		if ($file)
			$template->setFile($file);

		if ($this->translator) {
			$template->setTranslator($this->translator);
		}

		if ($control) {
			$presenter = $control->getPresenter(FALSE);
			$template->_control = $template->control = $control;
			$template->_presenter = $template->presenter = $presenter;

			if ($presenter) {
				$template->user = $presenter->getUser();
				$template->netteHttpResponse = $presenter->getContext()->httpResponse;
				$template->netteCacheStorage = $presenter->getContext()->cacheStorage;
				$template->baseUri = $template->baseUrl = rtrim($presenter->getContext()->httpRequest->getUrl()->getBaseUrl(), '/');
				$template->basePath = preg_replace('#https?://[^/]+#A', '', $template->baseUrl);

				if ($presenter->hasFlashSession()) {
					$id = $control->getParameterId('flash');
					$template->flashes = $presenter->getFlashSession()->$id;
				}
			}
		}

		if (!isset($template->flashes) || !is_array($template->flashes)) {
			$template->flashes = array();
		}

		return $template;
	}

}
