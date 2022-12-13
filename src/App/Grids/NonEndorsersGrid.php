<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Grids;

use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumn;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnFormat;

final class NonEndorsersGrid extends AbstractGrid
{
    /**
     * @inheritDoc
     */
    public function init(array $options = []): void
    {
        $col = new GridColumn();
        $col->id = 'committeeName';
        $col->title = 'Committee Name';
        $col->width = .25;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'committeeId';
        $col->title = 'Committee ID';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'candidateId';
        $col->title = 'Candidate ID';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'donors';
        $col->title = 'Donors';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'receipts';
        $col->title = 'Receipts';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'amt';
        $col->title = 'Amount';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $this[] = $col;
    }
}
