<?php

namespace Bin\Commands\Tests;

use App\InvalidStateException;
use App\Migrations\PhpClass;
use Bin\Commands\Command;
use Nette\Database\Context;
use Nette\DI\Container;
use Nette\Utils\Finder;
use Nextras\Migrations\Entities\File;
use Nextras\Migrations\Entities\Group;
use Nextras\Migrations\Extensions\NetteDbSql;
use Nextras\Migrations\IExtensionHandler;
use Symfony\Component\Console\Input\InputArgument;


class Data extends Command
{

	/**
	 * @var IExtensionHandler[]
	 */
	protected $runners;

	protected function configure()
	{
		$this->setName('tests:data')
			->setDescription('Inserts test data into current database')
			->addArgument('data', InputArgument::REQUIRED, 'File or directory to data files')
			->setHelp('All file formats as with migrations are supported: php and sql.');
	}

	public function invoke(Container $container, Context $context)
	{
		$this->runners = [
			'php' => new PhpClass([], $container),
			'sql' => new NetteDbSql($context),
		];

		$data = $this->in->getArgument('data');
		if (is_file($data))
		{
			$this->runFile($data);
		}
		else
		{
			foreach (Finder::findFiles('*.sql', '*.php')->from($data) as $file => $info)
			{
				$this->runFile($file);
			}
		}

		$this->out->writeln('<info>Data files invoked</info>');
	}

	/**
	 * @param string $path path
	 */
	protected function runFile($path)
	{
		$this->out->writeln($path);

		$ext = strToLower(pathinfo($path, PATHINFO_EXTENSION));
		if (!isset($this->runners[$ext]))
		{
			throw new InvalidStateException;
		}

		$group = new Group();
		$group->directory = dirname($path);
		$group->enabled = TRUE;
		$group->dependencies = [];

		$file = new File();
		$file->group = $group;
		$file->name = basename($path);

		$this->runners[$ext]->execute($file);
	}

}
