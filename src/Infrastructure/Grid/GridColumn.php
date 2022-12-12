<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Grid;

class GridColumn
{
    public ?string $class = null;
    public GridColumnFormat $format;
    public string $id = '';
    public ?GridColumnMeta $meta = null;
    public string $title = '';
    public ?float $width = null;

    /**
     *
     */
    public function __construct()
    {
        $this->format = new GridColumnFormat(GridColumnFormat::FORMAT_NONE);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        if (null !== $this->class) {
            return $this->class;
        }

        if (GridColumnFormat::FORMAT_NONE === (string)$this->format) {
            return 'text-left';
        }

        return 'text-center';
    }

    /**
     * @return void
     */
    public function __clone(): void
    {
        $this->format = clone $this->format;

        if (null !== $this->meta) {
            $this->meta = clone $this->meta;
        }
    }
}
