<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Domain\Entity\Committee;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;

use function is_array;
use function is_string;

/**
 * @extends AbstractCollection<string, Committee>
 */
final class CommitteeCollection extends AbstractCollection
{
    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                throw FecUnexpectedValueException::fromExpectedAndActual('', $key);
            }

            if (!is_array($value)) {
                throw FecUnexpectedValueException::fromExpectedAndActual([], $value);
            }

            $self[$key] = Committee::fromArray($value);
        }

        return $self;
    }
}
