<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Domain\Dto\FecReportedTotal;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;

use function is_array;
use function is_string;

/**
 * @extends AbstractCollection<string, FecReportedTotal>
 */
final class FecReportedTotalCollection extends AbstractCollection
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
                /** @noinspection PhpCastIsUnnecessaryInspection */
                $key = (string)$key;
            }

            if (!is_array($value)) {
                throw FecUnexpectedValueException::fromExpectedAndActual([], $value);
            }

            $self[$key] = FecReportedTotal::fromArray($value);
        }

        return $self;
    }
}
