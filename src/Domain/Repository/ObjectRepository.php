<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Repository;

use CliffordVickrey\FecReporter\Domain\Aggregate\EndorsersAggregate;
use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Domain\Collection\CommitteeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\EndorsementDateCollection;
use CliffordVickrey\FecReporter\Domain\Collection\EndorserByTotalTypeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\NonEndorserByTotalTypeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\PersonCollection;
use CliffordVickrey\FecReporter\Domain\Collection\TotalCollection;
use CliffordVickrey\FecReporter\Domain\Entity\CandidateSummary;
use CliffordVickrey\FecReporter\Exception\FecInvalidArgumentException;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\JsonUtilities;

use function crc32;
use function func_get_args;
use function in_array;
use function is_a;
use function serialize;
use function str_ends_with;

class ObjectRepository implements ObjectRepositoryInterface
{
    /** @var array<numeric-string, object> */
    private array $cache = [];

    /**
     * @inheritDoc
     */
    public function getObject(string $classname, mixed ...$params): object
    {
        if (str_ends_with($classname, 'Aggregate')) {
            $key = null;
        } else {
            $key = (string)crc32(serialize(func_get_args()));
        }

        if (null !== $key && isset($this->cache[$key]) && is_a($this->cache[$key], $classname)) {
            return $this->cache[$key];
        }

        $path = self::doGetPath($classname, $params);

        if ('' !== $path) {
            $filename = __DIR__ . "/../../../data/$path";
            $contents = FileUtilities::fileGetContents($filename);
            $data = JsonUtilities::jsonDecode($contents);
        } else {
            $data = [];
        }

        $obj = $this->doConstruct($classname, $data);

        if (null !== $key) {
            $this->cache[$key] = clone $obj;
        }

        return $obj;
    }

    /**
     * @param class-string $classname
     * @param array<mixed> $params
     * @return string
     */
    private static function doGetPath(string $classname, array $params): string
    {
        $firstParam = CastingUtilities::toString($params[0] ?? null);

        if (
            '' === $firstParam
            && in_array($classname, [
                CandidateSummary::class,
                EndorsementDateCollection::class,
                EndorserByTotalTypeCollection::class,
                NonEndorserByTotalTypeCollection::class,
                TotalCollection::class
            ])
        ) {
            throw new FecInvalidArgumentException('Candidate ID is required');
        }

        return match ($classname) {
            CandidateCollection::class => 'candidates/candidates.json',
            CandidateSummary::class => "totals/$firstParam.json",
            CommitteeCollection::class => 'committees/committees.json',
            EndorsersAggregate::class => '',
            EndorsementDateCollection::class => "endorser-dates/$firstParam.json",
            EndorserByTotalTypeCollection::class => "endorsers/$firstParam.json",
            NonEndorserByTotalTypeCollection::class => "non-endorsers/$firstParam.json",
            PersonCollection::class => 'people/people.json',
            TotalCollection::class => "subtotals/$firstParam.json",
            default => throw new FecInvalidArgumentException('Invalid class name')
        };
    }

    /**
     * @template T of object
     * @param class-string<T> $classname
     * @param array<mixed> $data
     * @return T
     */
    private function doConstruct(string $classname, array $data): object
    {
        // @phpstan-ignore-next-line
        return match ($classname) {
            CandidateCollection::class => CandidateCollection::fromArray($data),
            CandidateSummary::class => CandidateSummary::fromArray($data),
            CommitteeCollection::class => CommitteeCollection::fromArray($data),
            EndorsersAggregate::class => new EndorsersAggregate($this),
            EndorsementDateCollection::class => EndorsementDateCollection::fromArray($data),
            EndorserByTotalTypeCollection::class => EndorserByTotalTypeCollection::fromArray($data),
            NonEndorserByTotalTypeCollection::class => NonEndorserByTotalTypeCollection::fromArray($data),
            PersonCollection::class => PersonCollection::fromArray($data),
            default => TotalCollection::fromArray($data)
        };
    }
}
