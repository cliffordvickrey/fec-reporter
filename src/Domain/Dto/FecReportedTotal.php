<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Dto;

use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;

final class FecReportedTotal
{
    public float $itemized = 0.0;
    public float $unitemized = 0.0;

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->itemized = CastingUtilities::toFloat($data['itemized'] ?? null);
        $self->unitemized = CastingUtilities::toFloat($data['unitemized'] ?? null);
        return $self;
    }
}
