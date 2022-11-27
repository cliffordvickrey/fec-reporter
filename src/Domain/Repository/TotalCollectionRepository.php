<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Collection\TotalCollection;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\JsonUtilities;

class TotalCollectionRepository implements TotalCollectionRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getTotalCollection(string $candidateId): TotalCollection
    {
        $filename = __DIR__ . "/../../../data/subtotals/$candidateId.json";
        $contents = FileUtilities::fileGetContents($filename);
        $data = JsonUtilities::jsonDecode($contents);
        return TotalCollection::fromArray($data);
    }
}
