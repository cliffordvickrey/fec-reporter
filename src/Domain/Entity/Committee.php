<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Entity;

use CliffordVickrey\FecReporter\Domain\Collection\FecReportedTotalCollection;
use CliffordVickrey\FecReporter\Infrastructure\Contract\ToArray;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use JetBrains\PhpStorm\Pure;

use function array_map;
use function array_values;
use function is_array;
use function round;

final class Committee implements ToArray
{
    public string $candidateId = '';
    public string $committeeId = '';
    public string $name = '';
    /** @var string[] */
    public array $people = [];
    public FecReportedTotalCollection $fecReportedTotals;

    /**
     *
     */
    #[Pure]
    public function __construct()
    {
        $this->fecReportedTotals = new FecReportedTotalCollection();
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->candidateId = CastingUtilities::toString($data['candidateId'] ?? null);
        $self->committeeId = CastingUtilities::toString($data['committeeId'] ?? null);
        $self->name = CastingUtilities::toString($data['name'] ?? null);

        $people = $data['people'] ?? null;

        if (is_array($people)) {
            $self->people = array_values(array_map([CastingUtilities::class, 'toString'], $people));
        }

        $fecReportedTotals = $data['fecTotals'] ?? [];

        if (!is_array($fecReportedTotals)) {
            $fecReportedTotals = [];
        }

        $self->fecReportedTotals = FecReportedTotalCollection::fromArray($fecReportedTotals);

        return $self;
    }

    /**
     * @return void
     */
    public function __clone(): void
    {
        $this->fecReportedTotals = clone $this->fecReportedTotals;
    }

    /**
     * @return list<array{cycle: string, itemized: float, unitemized: float, all: float}>
     */
    public function toArray(): array
    {
        $arr = [];

        foreach ($this->fecReportedTotals as $cycle => $totals) {
            $arr[] = [
                'cycle' => $cycle,
                'itemized' => $totals->itemized,
                'unitemized' => $totals->unitemized,
                'all' => round($totals->itemized + $totals->unitemized, 2)
            ];
        }

        return $arr;
    }
}
