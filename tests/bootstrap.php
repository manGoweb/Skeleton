<?php

/** @var Container $container */
use Nette\DI\Container;
use Tests\TestCase;


$container = require __DIR__ . '/../app/bootstrap.php';
return $container;


function file_get_php_classes($path)
{
	$php_code = file_get_contents($path);
	$classes = get_php_classes($php_code);
	return $classes;
}

function get_php_classes($php_code)
{
	$classes = [];
	$tokens = token_get_all($php_code);
	$count = count($tokens);
	$namespace = '';
	for ($i = 2; $i < $count; $i++) {
		if ($tokens[$i - 2][0] === T_NAMESPACE
			&& $tokens[$i - 1][0] == T_WHITESPACE
			&& $tokens[$i][0] == T_STRING) {
			do {
				$namespace .= $tokens[$i][1];
				$i++;
			} while ($tokens[$i] !== ';');
		}
		if ($tokens[$i - 2][0] == T_CLASS
			&& $tokens[$i - 1][0] == T_WHITESPACE
			&& $tokens[$i][0] == T_STRING) {

			$class_name = $tokens[$i][1];
			$classes[] = "$namespace\\$class_name";
		}
	}
	return $classes;
}

function runTests($path, Container $container)
{
	foreach (file_get_php_classes($path) as $class)
	{
		/** @var TestCase $test */
		$test = new $class($container);
		$test->run();
	}
}
