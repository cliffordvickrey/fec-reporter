<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Entity\CandidateSummary;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\JsonUtilities;

class CandidateSummaryRepository implements CandidateSummaryRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getCandidateSummary(string $candidateId): CandidateSummary
    {
        $filename = __DIR__ . "/../../../data/totals/$candidateId.json";
        $contents = FileUtilities::fileGetContents($filename);
        $data = JsonUtilities::jsonDecode($contents);
        return CandidateSummary::fromArray($data);
    }
}
