<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\JsonUtilities;

class CandidateCollectionRepository implements CandidateCollectionRepositoryInterface
{
    /**
     * @return CandidateCollection
     */
    public function getCandidateCollection(): CandidateCollection
    {
        $filename = __DIR__ . '/../../../data/candidates/candidates.json';
        $contents = FileUtilities::fileGetContents($filename);
        $data = JsonUtilities::jsonDecode($contents);
        return CandidateCollection::fromArray($data);
    }
}
