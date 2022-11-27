<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Exception;

use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use UnexpectedValueException;

use function get_class;
use function is_object;
use function sprintf;

class FecUnexpectedValueException extends UnexpectedValueException
{
    /**
     * @param mixed $expected
     * @param mixed $actual
     * @return self
     */
    public static function fromExpectedAndActual(mixed $expected, mixed $actual): self
    {
        $msg = sprintf('Expected %s; got %s', self::getType($expected), self::getType($actual));
        return new self($msg);
    }

    /**
     * @param mixed $value
     * @param bool $classString
     * @return string
     */
    private static function getType(mixed $value, bool $classString = false): string
    {
        if ($classString) {
            return sprintf('instance of %s', CastingUtilities::toString($value));
        }

        if (is_object($value)) {
            return sprintf('instance of %s', get_class($value));
        }

        return gettype($value);
    }

    /**
     * @param string $expected
     * @param mixed $actual
     * @return self
     */
    public static function fromExpectedClassStringAndActual(string $expected, mixed $actual): self
    {
        $msg = sprintf('Expected %s; got %s', self::getType($expected, true), self::getType($actual));
        return new self($msg);
    }
}
