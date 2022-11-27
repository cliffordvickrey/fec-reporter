<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Grids;

use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumn;
use CliffordVickrey\FecReporter\Infrastructure\Grid\GridColumnFormat;

final class CandidateGrid extends AbstractGrid
{
    /**
     * @inheritDoc
     */
    public function init(array $options = []): void
    {
        $col = new GridColumn();
        $col->id = 'name';
        $col->title = 'Candidate Name';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'homeState';
        $col->title = 'Home State';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'fecCandidateId';
        $col->title = 'FEC Candidate Id';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'fecCommitteeId';
        $col->title = 'FEC Committee Id';
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'fecFilingDate';
        $col->title = 'FEC Filing Date';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_DATE);
        $this[] = $col;

        $col = new GridColumn();
        $col->id = 'withdrawalDate';
        $col->title = 'Withdrawal Date';
        $col->format = new GridColumnFormat(GridColumnFormat::FORMAT_DATE);
        $this[] = $col;
    }
}
