<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;

use function is_string;

/**
 * @extends AbstractCollection<string, string>
 */
final class PersonCollection extends AbstractCollection
{
    /**
     * @param array<mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                throw FecUnexpectedValueException::fromExpectedAndActual('', $key);
            }

            if (!is_string($value)) {
                throw FecUnexpectedValueException::fromExpectedAndActual('', $value);
            }

            $self[$key] = $value;
        }

        return $self;
    }
}
