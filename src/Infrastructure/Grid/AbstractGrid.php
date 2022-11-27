<?php

/** @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection */

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Grid;

use CliffordVickrey\FecReporter\Exception\FecLogicException;
use CliffordVickrey\FecReporter\Exception\FecUnexpectedValueException;
use CliffordVickrey\FecReporter\Infrastructure\Contract\AbstractCollection;
use CliffordVickrey\FecReporter\Infrastructure\Utility\ArrayUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;

use function array_combine;
use function array_fill;
use function array_key_exists;
use function array_key_last;
use function array_map;
use function array_reduce;
use function array_values;
use function count;
use function is_iterable;
use function round;
use function sprintf;

/**
 * @extends AbstractCollection<string, GridColumn>
 */
abstract class AbstractGrid extends AbstractCollection
{
    /** @var list<array<string, mixed>> */
    private array $values = [];

    /**
     * @param array<string, mixed> $options
     */
    final public function __construct(array $options = [])
    {
        $this->init($options);
    }

    /**
     * @param array<string, mixed> $options
     * @return void
     */
    abstract public function init(array $options = []): void;

    /**
     * @return list<array<string, mixed>>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array<mixed> $values
     */
    public function setValues(array $values): void
    {
        if (ArrayUtilities::isArrayAssociative($values)) {
            $values = [$values];
        }

        $formattedRows = [];

        $template = array_combine($this->getColumnIds(), array_fill(0, count($this), null));

        foreach ($values as $row) {
            $formattedRow = $template;

            if (!is_iterable($row)) {
                throw new FecUnexpectedValueException('Expected associate array or array of associated arrays');
            }

            foreach ($row as $k => $v) {
                $k = CastingUtilities::toString($k);

                if (array_key_exists($k, $formattedRow)) {
                    $formattedRow[$k] = $v;
                }
            }

            $formattedRows[] = $formattedRow;
        }

        $this->values = $formattedRows;
    }

    /**
     * @return string[]
     */
    public function getColumnIds(): array
    {
        return array_values(array_map(static fn(GridColumn $column) => $column->id, $this->data));
    }

    /**
     * @return list<array{title: string, colSpan: int}>
     */
    public function getMetaColSpans(): array
    {
        $reduced = array_reduce($this->data, static function (array $carry, GridColumn $column): array {
            if (null === $column->meta) {
                return $carry;
            } elseif ($column->meta->title === $carry['current']) {
                $carry['colSpans'][array_key_last($carry['colSpans'])]['colSpan']++;
            } else {
                $carry['current'] = $column->meta->title;
                $carry['colSpans'][] = ['title' => $column->meta->title, 'colSpan' => 1];
            }

            return $carry;
        }, [
            'current' => null,
            'colSpans' => []
        ]);

        return $reduced['colSpans'];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            $offset = $value->id;

            if (isset($this[$offset])) {
                $msg = sprintf('Column with ID "%s" already exists', $offset);
                throw new FecLogicException($msg);
            }
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * @return list<float>
     */
    public function getColWidths(): array
    {
        $count = count($this);

        if (0 === $count) {
            return [];
        }

        $reduced = array_reduce($this->data, static function (array $carry, GridColumn $column): array {
            if (null === $column->width) {
                return $carry;
            }

            $carry['count']++;
            $carry['sum'] += $column->width;
            return $carry;
        }, ['count' => 0, 'sum' => 0.0]);

        $remainingCount = $count - $reduced['count'];

        if (0 === $remainingCount) {
            $remainingWidth = 0.0;
        } else {
            $remainingWidth = round((1.0 - $reduced['sum']) / $remainingCount, 4);
        }

        $widths = [];

        foreach ($this->data as $column) {
            $widths[] = $column->width ?? $remainingWidth;
        }

        return $widths;
    }
}
