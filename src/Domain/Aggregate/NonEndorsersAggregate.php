<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Aggregate;

use CliffordVickrey\FecReporter\Domain\Collection\CommitteeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\NonEndorserByTotalTypeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\PersonCollection;
use CliffordVickrey\FecReporter\Domain\Entity\Committee;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Domain\Repository\ObjectRepositoryInterface;

use function array_keys;
use function array_merge;
use function array_reduce;
use function asort;
use function in_array;
use function uasort;

use const SORT_FLAG_CASE;
use const SORT_NATURAL;

final class NonEndorsersAggregate
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
    public function getNonEndorsersList(string $candidateId, TotalType $totalType): array
    {
        $arr = [];

        $committees = $this->objectRepository->getObject(CommitteeCollection::class);
        $nonEndorsersByType = $this->objectRepository->getObject(NonEndorserByTotalTypeCollection::class, $candidateId);

        if (!isset($nonEndorsersByType[$totalType])) {
            return $arr;
        }

        $nonEndorsers = $nonEndorsersByType[$totalType];
        $people = $this->objectRepository->getObject(PersonCollection::class);

        foreach ($nonEndorsers as $committeeId => $unused) {
            $committee = $committees[$committeeId];

            foreach ($committee->people as $committeePerson) {
                if (!isset($people[$committeePerson])) {
                    continue;
                }

                $arr[$committeePerson] = $people[$committeePerson];
            }
        }

        asort($arr, SORT_FLAG_CASE | SORT_NATURAL);

        return $arr;
    }

    /**
     * @param string $nonEndorsed
     * @param string $nonEndorser
     * @param TotalType $totalType
     * @return list<array<string, mixed>>
     */
    public function getNonEndorserCommittees(string $nonEndorsed, string $nonEndorser, TotalType $totalType): array
    {
        $committees = $this->objectRepository->getObject(CommitteeCollection::class);
        $allNonEndorsements = $this->objectRepository->getObject(NonEndorserByTotalTypeCollection::class, $nonEndorsed);
        $nonEndorsementsByCommittee = $allNonEndorsements[$totalType];

        $nonEndorserCommittees = [];

        foreach ($committees as $committeeSlug => $committee) {
            if (in_array($nonEndorser, $committee->people)) {
                $nonEndorserCommittees[$committeeSlug] = $committee;
            }
        }

        uasort($nonEndorserCommittees, fn(Committee $a, Committee $b) => $a->name <=> $b->name);

        $keys = array_keys($nonEndorserCommittees);

        $reduced = array_reduce(
            $nonEndorserCommittees,
            function (array $carry, Committee $committee) use ($nonEndorsementsByCommittee, $keys) {
                $row = [
                    'committeeName' => $committee->name,
                    'committeeId' => $committee->committeeId,
                    'candidateId' => $committee->candidateId,
                    'donors' => 0,
                    'receipts' => 0,
                    'amt' => 0.0
                ];

                $key = $keys[$carry['count']];

                if (isset($nonEndorsementsByCommittee[$key])) {
                    $subTotal = $nonEndorsementsByCommittee[$key];

                    $row = array_merge($row, [
                        'donors' => $subTotal->donors,
                        'receipts' => $subTotal->receipts,
                        'amt' => $subTotal->amt
                    ]);
                }

                $carry['committees'][] = $row;
                $carry['count']++;

                return $carry;
            },
            ['committees' => [], 'count' => 0]
        );

        return $reduced['committees'];
    }
}
