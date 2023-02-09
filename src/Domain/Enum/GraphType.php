<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Enum;

use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractEnum;
use JetBrains\PhpStorm\ArrayShape;

final class GraphType extends AbstractEnum
{
    public const TYPE_AMT = 'amt';
    public const TYPE_COUNT = 'count';

    /**
     * @inheritDoc
     */
    #[ArrayShape([self::TYPE_AMT => "string", self::TYPE_COUNT => "string"])]
    protected function getEnum(): array
    {
        return [self::TYPE_AMT => 'amount', self::TYPE_COUNT => 'count'];
    }
}
