<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Domain\Dto\SubTotalPanel;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;

use function is_array;
use function is_string;

/**
 * @extends AbstractCollection<string, SubTotalPanel>
 */
final class EndorserCollection extends AbstractCollection
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

            $self[$key] = SubTotalPanel::fromArray($value);
        }

        return $self;
    }
}
