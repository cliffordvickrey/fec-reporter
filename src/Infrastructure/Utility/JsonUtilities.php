<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Utility;

use CliffordVickrey\FecReporter\Exception\FecRuntimeException;

use function is_array;
use function json_decode;

class JsonUtilities
{
    /**
     * @param string $json
     * @return array<mixed>
     */
    public static function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (is_array($data)) {
            return $data;
        }

        throw new FecRuntimeException('Could not parse JSON document');
    }
}
