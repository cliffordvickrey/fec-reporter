<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;

interface CandidateCollectionRepositoryInterface
{
    /**
     * @return CandidateCollection
     */
    public function getCandidateCollection(): CandidateCollection;
}
