<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Aggregate;

use CliffordVickrey\FecReporter\Domain\Collection\CommitteeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\EndorserByTotalTypeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\PersonCollection;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Domain\Repository\ObjectRepositoryInterface;

use function asort;

use const SORT_FLAG_CASE;
use const SORT_NATURAL;

final class EndorsersAggregate
{
    /**
     * @param ObjectRepositoryInterface $objectRepository
     */
    public function __construct(private ObjectRepositoryInterface $objectRepository)
    {
    }

    /**
     * @param string $candidateId
     * @param TotalType $totalType
     * @return array<string, string>
     */
    public function getEndorsersList(string $candidateId, TotalType $totalType): array
    {
        $arr = [];

        $committees = $this->objectRepository->getObject(CommitteeCollection::class);
        $endorsersByType = $this->objectRepository->getObject(EndorserByTotalTypeCollection::class, $candidateId);

        if (!isset($endorsersByType[$totalType])) {
            return $arr;
        }

        $endorsers = $endorsersByType[$totalType];
        $people = $this->objectRepository->getObject(PersonCollection::class);

        foreach ($endorsers as $committeeId => $unused) {
            $committee = $committees[$committeeId];

            foreach ($committee->people as $committeePerson) {
                $arr[$committeePerson] = $people[$committeePerson];
            }
        }

        asort($arr, SORT_FLAG_CASE | SORT_NATURAL);

        return $arr;
    }
}
