<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Request;

use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;
use JetBrains\PhpStorm\Pure;

/**
 * @extends  AbstractCollection<string, mixed>
 */
final class Request extends AbstractCollection
{
    /**
     * @return self
     */
    #[Pure]
    public static function fromSuperGlobals(): self
    {
        $self = new self();
        $self->data = $_GET;
        return $self;
    }
}
