<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Collection;

use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;
use CliffordVickrey\FecReporter\Infrastructure\Contract\ToArray;
use JsonSerializable;

use function is_array;
use function is_string;

/**
 * @extends AbstractCollection<string, Candidate>
 */
final class CandidateCollection extends AbstractCollection implements JsonSerializable, ToArray
{
    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                throw FecUnexpectedValueException::fromExpectedAndActual('', $key);
            }

            if (!is_array($value)) {
                throw FecUnexpectedValueException::fromExpectedAndActual([], $value);
            }

            $self[$key] = Candidate::fromArray($value);
        }

        return $self;
    }

    /**
     * @return list<array{label: string, value: string}>
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * @return list<array{label: string, value: string}>
     */
    public function toArray(): array
    {
        $arr = [];

        foreach ($this->data as $candidate) {
            $arr[] = ['label' => $candidate->name, 'value' => $candidate->id];
        }

        return $arr;
    }
}
