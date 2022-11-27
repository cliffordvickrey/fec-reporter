<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Domain\Dto\SubTotal;
use CliffordVickrey\FecReporter\Domain\Enum\SubTotalType;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;
use CliffordVickrey\FecReporter\Infrastructure\Contract\ToArray;

use function array_walk;
use function in_array;
use function is_array;
use function round;

/**
 * @extends AbstractCollection<SubTotalType, SubTotal>
 */
final class SubTotalCollection extends AbstractCollection implements ToArray
{
    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        foreach ($data as $key => $value) {
            $subTotalType = new SubTotalType($key);

            if (!is_array($value)) {
                throw FecUnexpectedValueException::fromExpectedAndActual([], $value);
            }

            $self[$subTotalType] = SubTotal::fromArray($value);
        }

        return $self;
    }

    /**
     * @return list<array{subType: non-empty-string, donors: int, receipts: int, amt: float, pct: float}>
     */
    public function toArray(): array
    {
        $arr = [];

        $mutuallyExclusiveCategories = [
            SubTotalType::SUB_TYPE_ONE_DOLLAR,
            SubTotalType::SUB_TYPE_ONE_TO_TWO_HUNDRED_DOLLARS,
            SubTotalType::SUB_TYPE_TWO_HUNDRED_TO_ONE_THOUSAND_DOLLARS,
            SubTotalType::SUB_TYPE_ONE_THOUSAND_TO_TWENTY_EIGHT_HUNDRED_DOLLARS,
            SubTotalType::SUB_TYPE_TWENTY_EIGHT_HUNDRED_DOLLARS
        ];

        $total = 0;

        foreach ($this->data as $k => $v) {
            $subTotalType = new SubTotalType($k);

            if (in_array((string)$subTotalType, $mutuallyExclusiveCategories)) {
                $total += $v->donors;
            }

            $arr[] = [
                'subType' => $subTotalType->getDescription(),
                'donors' => $v->donors,
                'receipts' => $v->receipts,
                'amt' => $v->amt,
                'pct' => 0.0
            ];
        }

        if ($total > 0) {
            // look ma: no loops!
            array_walk($arr, fn(&$row) => $row['pct'] = round($row['donors'] / $total, 4));
        }

        return $arr;
    }
}
