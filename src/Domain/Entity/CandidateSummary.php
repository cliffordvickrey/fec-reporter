<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Entity;

use CliffordVickrey\FecReporter\Domain\Dto\SubTotal;
use CliffordVickrey\FecReporter\Infrastructure\Contract\ToArray;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class CandidateSummary implements ToArray
{
    public SubTotal $all;
    public SubTotal $itemized;
    public SubTotal $unitemized;

    /**
     *
     */
    #[Pure]
    public function __construct()
    {
        $this->all = new SubTotal();
        $this->itemized = new SubTotal();
        $this->unitemized = new SubTotal();
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    #[Pure]
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->all = SubTotal::fromArray(CastingUtilities::toArray($data['all'] ?? null));
        $self->itemized = SubTotal::fromArray(CastingUtilities::toArray($data['itemized'] ?? null));
        $self->unitemized = SubTotal::fromArray(CastingUtilities::toArray($data['unitemized'] ?? null));
        return $self;
    }

    /**
     * @return void
     */
    public function __clone(): void
    {
        $this->all = clone $this->all;
        $this->itemized = clone $this->itemized;
        $this->unitemized = clone $this->unitemized;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([
        'allDonors' => "int",
        'allReceipts' => "int",
        'allAmt' => "float",
        'itemizedDonors' => "int",
        'itemizedReceipts' => "int",
        'itemizedAmt' => "float",
        'unitemizedDonors' => "int",
        'unitemizedReceipts' => "int",
        'unitemizedAmt' => "float"
    ])]
    public function toArray(): array
    {
        return [
            'allDonors' => $this->all->donors,
            'allReceipts' => $this->all->receipts,
            'allAmt' => $this->all->amt,
            'itemizedDonors' => $this->itemized->donors,
            'itemizedReceipts' => $this->itemized->receipts,
            'itemizedAmt' => $this->itemized->amt,
            'unitemizedDonors' => $this->unitemized->donors,
            'unitemizedReceipts' => $this->unitemized->receipts,
            'unitemizedAmt' => $this->unitemized->amt
        ];
    }
}
