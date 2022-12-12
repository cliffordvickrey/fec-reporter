<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Domain\Collection\TotalCollection;
use CliffordVickrey\FecReporter\Domain\Entity\CandidateSummary;
use CliffordVickrey\FecReporter\Exception\FecInvalidArgumentException;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\JsonUtilities;

class ObjectRepository implements ObjectRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getObject(string $classname, mixed ...$params): object
    {
        $firstParam = CastingUtilities::toString($params[0] ?? null);

        if (
            '' === $firstParam
            && (CandidateSummary::class === $classname || TotalCollection::class === $classname)
        ) {
            throw new FecInvalidArgumentException('Candidate ID is required');
        }

        $path = match ($classname) {
            CandidateCollection::class => 'candidates/candidates.json',
            CandidateSummary::class => "totals/$firstParam.json",
            TotalCollection::class => "subtotals/$firstParam.json",
            default => throw new FecInvalidArgumentException('Invalid class name')
        };

        $filename = __DIR__ . "/../../../data/$path";
        $contents = FileUtilities::fileGetContents($filename);
        $data = JsonUtilities::jsonDecode($contents);

        // @phpstan-ignore-next-line
        return match ($classname) {
            CandidateCollection::class => CandidateCollection::fromArray($data),
            CandidateSummary::class => CandidateSummary::fromArray($data),
            default => TotalCollection::fromArray($data)
        };
    }
}
