<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Grids;

use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumn;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnFormat;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnMeta;

final class EndorsersGrid extends AbstractGrid
{
    /**
     * @inheritDoc
     */
    public function init(array $options = []): void
    {
        $meta = new GridColumnMeta();

        $col = new GridColumn();
        $col->id = 'committeeName';
        $col->title = 'Committee Name';
        $col->meta = $meta;
        $col->width = .25;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'committeeId';
        $col->title = 'Committee ID';
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'candidateId';
        $col->title = 'Candidate ID';
        $col->meta = $meta;
        $this[] = $col;

        $meta = new GridColumnMeta();
        $meta->title = 'Before Endorsement';

        $col = new GridColumn();
        $col->id = 'preDonors';
        $col->title = 'Donors';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'preReceipts';
        $col->title = 'Receipts';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'preAmt';
        $col->title = 'Amount';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->meta = $meta;
        $this[] = $col;

        $meta = new GridColumnMeta();
        $meta->title = 'After Endorsement';

        $col = new GridColumn();
        $col->id = 'postDonors';
        $col->title = 'Donors';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'postReceipts';
        $col->title = 'Receipts';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'postAmt';
        $col->title = 'Amount';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->meta = $meta;
        $this[] = $col;

        $meta = new GridColumnMeta();
        $meta->title = 'Total';

        $col = new GridColumn();
        $col->id = 'allDonors';
        $col->title = 'Donors';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'allReceipts';
        $col->title = 'Receipts';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'allAmt';
        $col->title = 'Amount';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->meta = $meta;
        $this[] = $col;
    }
}
