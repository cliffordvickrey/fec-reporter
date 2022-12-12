<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Grids;

use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumn;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnFormat;

final class FecHistoryGrid extends AbstractGrid
{
    /**
     * @inheritDoc
     */
    public function init(array $options = []): void
    {
        $col = new GridColumn();
        $col->class = 'text-center';
        $col->id = 'cycle';
        $col->title = 'Cycle';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'itemized';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->title = 'Itemized Receipts';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'unitemized';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->title = 'Unitemized Receipts';
        $this[] = $col;
    }
}
