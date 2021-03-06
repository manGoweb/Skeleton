<?php

namespace Tests;

use Nette\DI\Container;


class Helper
{

	public static function getFilePhpClasses($path)
	{
		$code = file_get_contents($path);
		$classes = static::getPhpClasses($code);
		return $classes;
	}

	public static function getPhpClasses($code)
	{
		$classes = [];
		$tokens = token_get_all($code);
		$count = count($tokens);
		$namespace = '';
		for ($i = 2; $i < $count; $i++)
		{
			if ($tokens[$i - 2][0] === T_NAMESPACE
				&& $tokens[$i - 1][0] == T_WHITESPACE
				&& $tokens[$i][0] == T_STRING)
			{
				do
				{
					$namespace .= $tokens[$i][1];
					$i++;
				}
				while ($tokens[$i] !== ';');
			}
			if ($tokens[$i - 2][0] == T_CLASS
				&& $tokens[$i - 1][0] == T_WHITESPACE
				&& $tokens[$i][0] == T_STRING)
			{
				$className = $tokens[$i][1];
				$classes[] = "$namespace\\$className";
			}
		}
		return $classes;
	}

	public static function runTests($path, Container $container)
	{
		global $argv;
		$tests = $argv;
		array_shift($tests);

		foreach (static::getFilePhpClasses($path) as $class)
		{
			/** @var TestCase $test */
			$test = new $class($container);
			if (!$tests)
			{
				$test->run();
			}

			$first = TRUE;
			foreach ($test->getTests() as $method)
			{
				foreach ($tests as $name)
				{
					if (strpos(strToLower($method), strToLower($name)) !== FALSE)
					{
						if (!$first)
						{
							echo "\n";
						}
						echo "\033[01;33m$method\033[0m\n";
						$test->runTest($method);
						$first = FALSE;
					}
				}
			}
		}
	}

}
