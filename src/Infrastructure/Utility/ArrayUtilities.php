<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Utility;

use function array_keys;
use function range;

class ArrayUtilities
{
    /**
     * @param array<mixed> $arr
     * @return bool
     */
    public static function isArrayAssociative(array $arr): bool
    {
        if (0 === count($arr)) {
            return false;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
