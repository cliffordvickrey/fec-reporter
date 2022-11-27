<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Dto;

use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use JetBrains\PhpStorm\Pure;

final class SubTotal
{
    public float $amt = 0.0;
    /** @var int<0, max> */
    public int $donors = 0;
    /** @var int<0, max> */
    public int $receipts = 0;

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    #[Pure]
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->amt = CastingUtilities::toFloat($data['amt'] ?? null);
        $self->donors = CastingUtilities::toUnsignedInt($data['donors'] ?? null);
        $self->receipts = CastingUtilities::toUnsignedInt($data['receipts'] ?? null);
        return $self;
    }
}
