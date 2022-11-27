<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Grid;

use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractEnum;
use JetBrains\PhpStorm\ArrayShape;

class GridColumnFormat extends AbstractEnum
{
    public const FORMAT_CURRENCY = 'currency';
    public const FORMAT_DATE = 'date';
    public const FORMAT_NONE = 'none';
    public const FORMAT_NUMBER = 'number';
    public const FORMAT_PERCENT = 'percent';

    /**
     * @return array<string, string>
     */
    #[ArrayShape([
        self::FORMAT_CURRENCY => "string",
        self::FORMAT_DATE => "string",
        self::FORMAT_NONE => "string",
        self::FORMAT_NUMBER => "string",
        self::FORMAT_PERCENT => "string"
    ])]
    protected function getEnum(): array
    {
        return [
            self::FORMAT_CURRENCY => self::FORMAT_CURRENCY,
            self::FORMAT_DATE => self::FORMAT_DATE,
            self::FORMAT_NONE => self::FORMAT_NONE,
            self::FORMAT_NUMBER => self::FORMAT_NUMBER,
            self::FORMAT_PERCENT => self::FORMAT_PERCENT
        ];
    }
}
