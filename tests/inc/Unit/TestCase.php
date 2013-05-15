<?php

namespace Tests\Unit;

use App;
use Nette;
use Orm;
use DibiConnection;
use SystemContainer;


/**
 * Base class for all test cases
 *
 * @author Jan Tvrdík
 * @author Petr Procházka
 *
 * @property-read App\RepositoryContainer $orm
 * @property-read DibiConnection $dibi
 * @property-read SystemContainer $context
 * @property-read TestPresenter $presenter
 */
abstract class TestCase extends ObjectTestCase
{

	/** @var Nette\DI\Container */
	private $context;

	/** @return Nette\DI\Container */
	public function getContext()
	{
		if ($this->context === NULL) {
			$this->context = $GLOBALS['diContainer'];
		}
		return $this->context;
	}

	/** @return App\RepositoryContainer */
	public function getOrm()
	{
		return $this->getContext()->orm;
	}

	/** @return DibiConnection */
	public function getDibi()
	{
		return $this->getContext()->dibi->connection;
	}

	/** @return TestPresenter */
	public function getPresenter()
	{
		return $this->getContext()->testPresenter;
	}

	/**
	 * @param Nette\Application\UI\Form
	 * @return FormSubmitter
	 */
	public function createFormSubmitter(Nette\Application\UI\Form $form)
	{
		$fs = new FormSubmitter;
		$fs->setPresenter(new TestPresenter($this->getContext()));
		$fs->setForm($form);
		return $fs;
	}

	/**
	 * Vytvori, naplni nahodnyma datama a persistuje entitu.
	 *
	 * @see Orm\TestHelper\EntityCreator
	 *
	 * @author Petr Procházka
	 * @param string|Orm\IEntity entity class name or object
	 * @param array (key => value) non-random data
	 * @param Orm\IRepository|NULL null means autodetect from entity name
	 * @return Orm\IEntity
	 */
	public function e($e, array $params = array(), Orm\IRepository $repo = NULL)
	{
		return $this->getContext()->entityCreator->create($e, $params, $repo);
	}

	/**
	 * Vynucuje existenci @covers anotace při generování code coverage.
	 *
	 * @author Jan Tvrdík
	 * @return mixed
	 */
	protected function runTest()
	{
		if ($this->getTestResultObject()->getCollectCodeCoverageInformation())
		{
			$annotations = $this->getAnnotations();
			if (!isset($annotations['class']['covers']) && !isset($annotations['method']['covers']))
			{
				throw new \Exception('Chybí povinná @covers anotace!');
			}
		}
		return parent::runTest();
	}


	protected function setUp()
	{
		parent::setUp();
		// volí výchozí databázi (při spuštění spolu se Seleniovými testy je jejich databáze odstraněna)
		$db = $this->getContext()->parameters['database']['database'];
		$this->context->dibiConnection->query('USE %n', $db);
	}

	/**
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		parent::tearDown();
	}

	/**
	 * Zkontroluje, že daný callback vyhodí danou vyjímku.
	 *
	 * <code>
	 *	$this->assertThrows(function () use ($object) {
	 *      $object->foo(NULL);
	 *  }, 'Tripilot\InvalidArgumentException', 'Service name must be a non-empty string, NULL given.');
	 * </code>
	 *
	 * @author Jan Tvrdík
	 * @param  callback
	 * @param  string      název výjimky (třeba Tripilot\InvalidStateException)
	 * @param  string|NULL text výjimky
	 * @param  string      informační hláška zobrazená při vyhození špatné výjimky
	 * @return void
	 */
	public static function assertThrows($callback, $exceptionName, $exceptionMessage = NULL, $message = '')
	{
		try
		{
			call_user_func($callback);
			self::fail("Expected $exceptionName.");
		}
		catch (\PHPUnit_Framework_AssertionFailedError $e)
		{
			throw $e;
		}
		catch (\Exception $e)
		{
			self::assertInstanceOf($exceptionName, $e, $message);
			if ($exceptionMessage)
			{
				self::assertSame($exceptionMessage, $e->getMessage(), $message);
			}
		}
	}

	public function removeListeners(Orm\IRepository $repository)
	{
		$this->context->eventsResetter->removeListeners($repository);
	}

}
