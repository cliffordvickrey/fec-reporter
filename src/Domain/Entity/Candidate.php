<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Entity;

use CliffordVickrey\FecReporter\Infrastructure\Contract\ToArray;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use DateTimeImmutable;
use JetBrains\PhpStorm\ArrayShape;

final class Candidate implements ToArray
{
    public string $id = '';
    public string $name = '';
    public string $homeState = '';
    public string $fecCandidateId = '';
    public string $fecCommitteeId = '';
    public ?DateTimeImmutable $exploratoryDate = null;
    public ?DateTimeImmutable $fecFilingDate = null;
    public ?DateTimeImmutable $withdrawalDate = null;

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $self = new self();
        $self->id = CastingUtilities::toString($data['id'] ?? null);
        $self->name = CastingUtilities::toString($data['name'] ?? null);
        $self->homeState = CastingUtilities::toString($data['homeState'] ?? null);
        $self->fecCandidateId = CastingUtilities::toString($data['fecCandidateId'] ?? null);
        $self->fecCommitteeId = CastingUtilities::toString($data['fecCommitteeId'] ?? null);
        $self->exploratoryDate = CastingUtilities::toDateTimeImmutable($data['exploratoryDate'] ?? null);
        $self->fecFilingDate = CastingUtilities::toDateTimeImmutable($data['fecFilingDate'] ?? null);
        $self->withdrawalDate = CastingUtilities::toDateTimeImmutable($data['withdrawalDate'] ?? null);
        return $self;
    }

    /**
     * @return void
     */
    public function __clone(): void
    {
        if (null !== $this->exploratoryDate) {
            $this->exploratoryDate = clone $this->exploratoryDate;
        }

        if (null !== $this->fecFilingDate) {
            $this->fecFilingDate = clone $this->fecFilingDate;
        }

        if (null !== $this->withdrawalDate) {
            $this->withdrawalDate = clone $this->withdrawalDate;
        }
    }

    /**
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'id' => "string",
        'name' => "string",
        'homeState' => "string",
        'fecCandidateId' => "string",
        'fecCommitteeId' => "string",
        'exploratoryDate' => "\DateTimeImmutable|null",
        'fecFilingDate' => "\DateTimeImmutable|null",
        'withdrawalDate' => "\DateTimeImmutable|null"
    ])]
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'homeState' => $this->homeState,
            'fecCandidateId' => $this->fecCandidateId,
            'fecCommitteeId' => $this->fecCommitteeId,
            'exploratoryDate' => $this->exploratoryDate,
            'fecFilingDate' => $this->fecFilingDate,
            'withdrawalDate' => $this->withdrawalDate
        ];
    }
}
