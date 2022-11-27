<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Contract;

use Stringable;

interface UserEnum extends Stringable
{
    /**
     * @return non-empty-string
     */
    public function getDescription(): string;

    /**
     * @return non-empty-string
     */
    public function getValue(): string;

    /**
     * @return non-empty-string
     */
    public function __toString(): string;
}
