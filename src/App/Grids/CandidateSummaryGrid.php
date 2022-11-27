<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Grids;

use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumn;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnFormat;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnMeta;

final class CandidateSummaryGrid extends AbstractGrid
{
    /**
     * @inheritDoc
     */
    public function init(array $options = []): void
    {
        $meta = new GridColumnMeta();
        $meta->title = 'Overall';

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

        $meta = new GridColumnMeta();
        $meta->title = 'Itemized';

        $col = new GridColumn();
        $col->id = 'itemizedDonors';
        $col->title = 'Donors';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'itemizedReceipts';
        $col->title = 'Receipts';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'itemizedAmt';
        $col->title = 'Amount';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->meta = $meta;
        $this[] = $col;

        $meta = new GridColumnMeta();
        $meta->title = 'Unitemized';

        $col = new GridColumn();
        $col->id = 'unitemizedDonors';
        $col->title = 'Donors';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'unitemizedReceipts';
        $col->title = 'Receipts';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_NUMBER);
        $col->meta = $meta;
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'unitemizedAmt';
        $col->title = 'Amount';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_CURRENCY);
        $col->meta = $meta;
        $this[] = $col;
    }
}
