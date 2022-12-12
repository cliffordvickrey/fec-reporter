<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Domain\Dto;

use JetBrains\PhpStorm\Pure;

use function is_array;

final class SubTotalPanel
{
    public SubTotal $pre;
    public SubTotal $post;
    public SubTotal $all;

    /**
     *
     */
    #[Pure]
    public function __construct()
    {
        $this->pre = new SubTotal();
        $this->post = new SubTotal();
        $this->all = new SubTotal();
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    #[Pure]
    public static function fromArray(array $data): self
    {
        $self = new self();

        $pre = $data['pre'] ?? [];

        if (is_array($pre)) {
            $self->pre = SubTotal::fromArray($pre);
        }

        $pre = $data['pre'] ?? [];

        if (is_array($pre)) {
            $self->pre = SubTotal::fromArray($pre);
        }

        $all = $data['all'] ?? [];

        if (is_array($all)) {
            $self->all = SubTotal::fromArray($all);
        }

        return $self;
    }
}
