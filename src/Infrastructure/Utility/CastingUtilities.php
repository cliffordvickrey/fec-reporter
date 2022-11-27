<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Utility;

use DateTimeImmutable;
use Stringable;
use Throwable;

use function abs;
use function is_array;
use function is_numeric;
use function is_scalar;
use function round;

class CastingUtilities
{
    /**
     * @param mixed $value
     * @return int<0, max>
     */
    public static function toUnsignedInt(mixed $value): int
    {
        if (is_numeric($value)) {
            return abs((int)$value);
        }

        return 0;
    }

    /**
     * @return array<mixed>
     */
    public static function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (null === $value || is_scalar($value)) {
            return [];
        }

        return (array)$value;
    }

    /**
     * @param mixed $value
     * @param int|null $precision
     * @return float
     */
    public static function toFloat(mixed $value, ?int $precision = null): float
    {
        if (is_numeric($value)) {
            $value = (float)$value;
        } else {
            $value = 0.0;
        }

        if (null !== $precision) {
            return round($value, $precision);
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @param non-empty-string|null $format
     * @return DateTimeImmutable|null
     */
    public static function toDateTimeImmutable(mixed $value, ?string $format = 'Y-m-d'): ?DateTimeImmutable
    {
        if ($value instanceof DateTimeImmutable) {
            return $value;
        }

        $value = self::toString($value);

        if ('' === $value) {
            return null;
        }

        $dateTime = null;

        if (null !== $format) {
            $dateTime = DateTimeImmutable::createFromFormat($format, $value);
        }

        if (false === $dateTime) {
            return null;
        }

        try {
            $dateTime = new DateTimeImmutable($value);
        } catch (Throwable) {
        }

        return $dateTime;
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function toString(mixed $value): string
    {
        if (is_scalar($value) || ($value instanceof Stringable)) {
            return (string)$value;
        }

        return '';
    }
}
