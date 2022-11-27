<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Contract;

interface ToArray
{
    /**
     * @return array<mixed>
     */
    public function toArray(): array;
}
