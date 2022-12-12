<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use DateTimeImmutable;

use function is_string;
use function sprintf;

/**
 * @extends AbstractCollection<string, DateTimeImmutable>
 */
final class EndorsementDateCollection extends AbstractCollection
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

            $dateTime = CastingUtilities::toDateTimeImmutable($value);

            if (null === $dateTime) {
                $msg = sprintf("Could not parse date, '%s'", CastingUtilities::toString($value));
                throw new FecUnexpectedValueException($msg);
            }

            $self[$key] = $value;
        }

        return $self;
    }
}
