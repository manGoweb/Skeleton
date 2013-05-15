<?php

namespace Tests\Unit;

use Nette;


/**
 * Nasimuluje odeslání formuláře.
 *
 * <code>
 * protected function setUp()
 * {
 * 	$this->formSubmitter = new FormSubmitter;
 * 	$this->formSubmitter->setForm(new FooForm);
 * 	$this->formSubmitter->setPresenter($this->context->testPresenter);
 * }
 *
 * public function test()
 * {
 * 	$response = $this->formSubmitter->submit(array('name' => 'Foo'));
 * }
 * <code>
 *
 * @see TestCase::createFormSubmitter()
 *
 * @author Jan Tvrdík
 * @author Petr Procházka
 */
class FormSubmitter extends Nette\Object
{

	/** @var Nette\Application\UI\Form */
	private $form;

	/** @var Nette\Application\UI\Presenter */
	private $presenter;

	/** @var array */
	private $presenterParams = array();

	/** @var string */
	private $formName = 'testForm';

	/** @var string */
	private $presenterName = 'Test';

	/**
	 * Nasimuluje odeslání formuláře.
	 *
	 * @param array data, kterými se formulář naplní
	 * @return Nette\Application\IResponse odpověď serveru na odeslání formuláře
	 */
	public function submit(array $formData)
	{
		if (!$this->form)
		{
			throw new \Exception('FormSubmitter: nejprve nastavte formular (setForm).');
		}
		if ($this->form->isAnchored())
		{
			throw new \Exception('FormSubmitter: formular je pripojen na jiny presenter.');
		}
		if (!$this->presenter)
		{
			throw new \Exception('FormSubmitter: nejprve nastavte presenter (setPresenter).');
		}

		$acccess = Access($this->form);
		$acccess->submittedBy = NULL;
		$acccess->httpData = NULL;
		$this->form->cleanErrors();

		if ($this->presenter instanceof TestPresenter)
		{
			$form = $this->form;
			$formName = $this->formName;
			$this->presenter->onCreateComponent[__CLASS__] = function ($presenter, $name) use ($form, $formName) {
				if ($name === $formName)
				{
					$presenter->addComponent($form, $formName);
				}
			};
		}
		else
		{
			// pred pripojenim formulare musi byt vse pripraveno
			// takze se run spousti dvakrat
			try
			{
				$this->presenter->run($this->createRequest($formData));
				throw new \Exception;
			}
			catch (Nette\Application\UI\BadSignalException $e)
			{
			}
			$this->presenter->addComponent($this->form, $this->formName);
		}

		$e = NULL;
		try
		{
			$response = $this->presenter->run($this->createRequest($formData));
		}
		catch (\Exception $e)
		{
		}

		if ($this->presenter instanceof TestPresenter)
		{
			unset($this->presenter->onCreateComponent[__CLASS__]);
		}
		$this->presenter->removeComponent($this->form);

		if ($e) throw $e;
		return $response;
	}

	/**
	 * @param Nette\Application\UI\Form instance formuláře, který chceme odeslat
	 * @param string Název testovacího formuláře
	 * @return FormSubmitter $this
	 * @todo Umožnit kromě instance formuláře ($form) předat i název třídy?
	 */
	public function setForm(Nette\Application\UI\Form $form, $formName = 'testForm')
	{
		$this->form = $form;
		$this->formName = $formName;
		return $this;
	}

	/**
	 * @param Nette\Application\UI\Presenter presenter, ke kterému se formulář připojí
	 * @param Nette\Application\Request|array|NULL parametry předané presenteru nebo celý aplikační požadavek
	 * @param string Název testovacího presenteru
	 * @return FormSubmitter $this
	 */
	public function setPresenter(Nette\Application\UI\Presenter $presenter, $params = array(), $presenterName = 'Test')
	{
		$this->presenter = $presenter;
		$this->presenterParams = $params;
		$this->presenterName = $presenterName;
		return $this;
	}

	/**
	 * @param array
	 * @return Nette\Application\Request
	 */
	protected function createRequest(array $formData)
	{
		$signal = array(Nette\Application\UI\Presenter::SIGNAL_KEY => ($this->formName . '-submit'));

		if ($this->presenterParams instanceof Nette\Application\Request)
		{
			$request = $this->presenterParams;
			$request->setParameters($request->getParameters() + $signal);
		}
		else
		{
			$request = new Nette\Application\Request(
				$this->presenterName,
				'post',
				$this->presenterParams + $signal,
				$formData
			);
		}

		return $request;
	}

}
