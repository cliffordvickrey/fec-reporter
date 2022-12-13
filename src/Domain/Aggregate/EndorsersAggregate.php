<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Aggregate;

use CliffordVickrey\FecReporter\Domain\Collection\CommitteeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\EndorsementDateCollection;
use CliffordVickrey\FecReporter\Domain\Collection\EndorserByTotalTypeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\PersonCollection;
use CliffordVickrey\FecReporter\Domain\Entity\Committee;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Domain\Repository\ObjectRepositoryInterface;
use DateTimeImmutable;

use function array_keys;
use function array_merge;
use function array_reduce;
use function asort;
use function in_array;
use function uasort;

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
        $endorsementDates = $this->objectRepository->getObject(EndorsementDateCollection::class, $candidateId);

        foreach ($endorsers as $committeeId => $unused) {
            $committee = $committees[$committeeId];

            foreach ($committee->people as $committeePerson) {
                if (!isset($people[$committeePerson]) || !isset($endorsementDates[$committeePerson])) {
                    continue;
                }

                $arr[$committeePerson] = $people[$committeePerson];
            }
        }

        asort($arr, SORT_FLAG_CASE | SORT_NATURAL);

        return $arr;
    }

    /**
     * @param string $endorsed
     * @param string $endorser
     * @return DateTimeImmutable
     */
    public function getEndorsementDate(string $endorsed, string $endorser): DateTimeImmutable
    {
        $endorsementDates = $this->objectRepository->getObject(EndorsementDateCollection::class, $endorsed);
        return $endorsementDates[$endorser];
    }

    /**
     * @param string $endorsed
     * @param string $endorser
     * @param TotalType $totalType
     * @return list<array<string, mixed>>
     */
    public function getEndorserCommittees(string $endorsed, string $endorser, TotalType $totalType): array
    {
        $committees = $this->objectRepository->getObject(CommitteeCollection::class);
        $allEndorsements = $this->objectRepository->getObject(EndorserByTotalTypeCollection::class, $endorsed);
        $endorsementsByCommittee = $allEndorsements[$totalType];

        $endorserCommittees = [];

        foreach ($committees as $committeeSlug => $committee) {
            if (in_array($endorser, $committee->people)) {
                $endorserCommittees[$committeeSlug] = $committee;
            }
        }

        uasort($endorserCommittees, fn(Committee $a, Committee $b) => $a->name <=> $b->name);

        $keys = array_keys($endorserCommittees);

        $reduced = array_reduce(
            $endorserCommittees,
            function (array $carry, Committee $committee) use ($endorsementsByCommittee, $keys) {
                $row = [
                    'committeeName' => $committee->name,
                    'committeeId' => $committee->committeeId,
                    'candidateId' => $committee->candidateId,
                    'preDonors' => 0,
                    'preReceipts' => 0,
                    'preAmt' => 0.0,
                    'postDonors' => 0,
                    'postReceipts' => 0,
                    'postAmt' => 0.0,
                    'allDonors' => 0,
                    'allReceipts' => 0,
                    'allAmt' => 0.0
                ];

                $key = $keys[$carry['count']];

                if (isset($endorsementsByCommittee[$key])) {
                    $endorsements = $endorsementsByCommittee[$key];

                    $row = array_merge($row, [
                        'preDonors' => $endorsements->pre->donors,
                        'preReceipts' => $endorsements->pre->receipts,
                        'preAmt' => $endorsements->pre->amt,
                        'postDonors' => $endorsements->post->donors,
                        'postReceipts' => $endorsements->post->receipts,
                        'postAmt' => $endorsements->post->amt,
                        'allDonors' => $endorsements->all->donors,
                        'allReceipts' => $endorsements->all->receipts,
                        'alAmt' => $endorsements->all->amt
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
