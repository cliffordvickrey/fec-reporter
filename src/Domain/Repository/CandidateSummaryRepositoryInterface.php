<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Entity\CandidateSummary;

interface CandidateSummaryRepositoryInterface
{
    /**
     * @param non-empty-string $candidateId
     * @return CandidateSummary
     */
    public function getCandidateSummary(string $candidateId): CandidateSummary;
}
