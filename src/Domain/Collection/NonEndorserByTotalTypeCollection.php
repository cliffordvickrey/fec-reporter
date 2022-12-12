<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;

use function is_array;

/**
 * @extends AbstractCollection<TotalType, NonEndorserCollection>
 */
final class NonEndorserByTotalTypeCollection extends AbstractCollection
{
    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        foreach ($data as $key => $value) {
            $totalType = new TotalType($key);

            if (!is_array($value)) {
                throw FecUnexpectedValueException::fromExpectedAndActual([], $value);
            }

            $self[$totalType] = NonEndorserCollection::fromArray($value);
        }

        return $self;
    }
}
