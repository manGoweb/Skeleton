<?php

/**
 * This file is part of the Nextras\ORM library.
 *
 * @license    MIT
 * @link       https://github.com/nextras/orm
 * @author     Jan Skrasek
 */

namespace Nextras\Orm\Entity\Collection;


use Closure;
use Nextras\Orm\InvalidArgumentException;
use Nextras\Orm\InvalidStateException;
use Nextras\Orm\Relationships\IRelationshipCollection;


class ArrayCollectionClosureHelper
{

	/**
	 * @param  string
	 * @param  mixed
	 * @return Closure
	 */
	public static function createFilter($condition, $value)
	{
		list($chain, $isNegation) = ConditionParser::parseCondition($condition);

		if (!$isNegation) {
			if (is_array($value)) {
				$predicate = function($property) use ($value) {
					return in_array($property, $value, TRUE);
				};
			} else {
				$predicate = function($property) use ($value) {
					return $property === $value;
				};
			}
		} else {
			if (is_array($value)) {
				$predicate = function($property) use ($value) {
					return !in_array($property, $value, TRUE);
				};
			} else {
				$predicate = function($property) use ($value) {
					return $property !== $value;
				};
			}
		}

		return static::createFilterEvaluator($chain, $predicate);
	}


	protected static function createFilterEvaluator($chainSource, Closure $predicate)
	{
		$evaluator = function($element, $chain = NULL) use (& $evaluator, $predicate, $chainSource) {
			if (!$chain) {
				$chain = $chainSource;
			}

			$key = array_shift($chain);
			$element = $element->$key;

			if (!$chain) {
				return $predicate($element);
			}

			if ($element === NULL) {
				return FALSE;

			} elseif ($element instanceof IRelationshipCollection) {
				foreach ($element as $node) {
					if ($evaluator($node, $chain)) {
						return TRUE;
					}
				}

				return FALSE;
			} else {
				return $evaluator($element, $chain);
			}
		};

		return $evaluator;
	}


	/**
	 * @param  string
	 * @param  string
	 * @return Closure
	 */
	public static function createSorter($condition, $direction)
	{
		list($chain, $isNegation) = ConditionParser::parseCondition($condition);
		if ($isNegation) {
			throw new InvalidArgumentException('Sorting can not be done with negative expression.');
		}

		$getter = function($element, $chain) use (& $getter) {
			$key = array_shift($chain);
			$element = $element->$key;
			if ($element instanceof IRelationshipCollection) {
				throw new InvalidStateException('You can not sort by hasMany relationship.');
			}

			if (!$chain) {
				return $element;
			} else {
				return $getter($element, $chain);
			}
		};

		$direction = $direction === ICollection::ASC ? 1 : -1;

		return function ($a, $b) use ($getter, $chain, $direction) {
			$_a = $getter($a, $chain);
			$_b = $getter($b, $chain);
			if (is_int($_a)) {
				return $direction * ($_a < $_b ? -1 : 1);
			} else {
				return $direction * (strcmp((string) $_a, (string) $_b));
			}
		};
	}

}
