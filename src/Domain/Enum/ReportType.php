<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Enum;

use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractEnum;
use JetBrains\PhpStorm\ArrayShape;

final class ReportType extends AbstractEnum
{
    public const ENDORSED = 'endorsed';
    public const ENDORSER = 'endorser';

    /**
     * @return array<string, string>
     */
    #[ArrayShape([self::ENDORSED => "string", self::ENDORSER => "string"])]
    protected function getEnum(): array
    {
        return [
            self::ENDORSED => 'Candidate receipts',
            self::ENDORSER => 'Endorser receipts'
        ];
    }
}
