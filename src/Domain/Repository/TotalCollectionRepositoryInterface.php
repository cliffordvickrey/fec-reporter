<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Collection\TotalCollection;

interface TotalCollectionRepositoryInterface
{
    /**
     * @param non-empty-string $candidateId
     * @return TotalCollection
     */
    public function getTotalCollection(string $candidateId): TotalCollection;
}
