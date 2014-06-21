<?php

namespace Nextras\Orm\Tests\Entity\Collection;

use Mockery;
use Nextras\Orm\Entity\Collection\ConditionParser;
use Nextras\Orm\Tests\TestCase;
use Tester\Assert;

$dic = require_once __DIR__ . '/../../../bootstrap.php';


/**
 * @testCase
 */
class ConditionParserTest extends TestCase
{

	public function testParse()
	{
		Assert::same([['column'], FALSE], ConditionParser::parseCondition('column'));
		Assert::same([['column', 'name'], FALSE], ConditionParser::parseCondition('this->column->name'));
		Assert::same([['column', 'name'], TRUE], ConditionParser::parseCondition('this->column->name!'));
	}


	public function testFailing()
	{
		Assert::throws(function () {
			ConditionParser::parseCondition('column->name');
		}, 'Nextras\Orm\InvalidArgumentException');

		Assert::throws(function () {
			ConditionParser::parseCondition('this->property.column');
		}, 'Nextras\Orm\InvalidArgumentException');

		Assert::throws(function () {
			ConditionParser::parseCondition('column.name');
		}, 'Nextras\Orm\InvalidArgumentException');
	}

}


$test = new ConditionParserTest($dic);
$test->run();
