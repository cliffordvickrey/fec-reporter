<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Grids\CandidateGrid;
use CliffordVickrey\FecReporter\App\Grids\CandidateSummaryGrid;
use CliffordVickrey\FecReporter\App\Grids\FecHistoryGrid;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;

$response = $response ?? new Response();
$view = $view ?? new View();

$candidate = $response->getObject(Candidate::class);
$candidateGrid = $response->getObject(CandidateGrid::class);
$summaryGrid = $response->getObject(CandidateSummaryGrid::class);
$historyGrid = $response->getObject(FecHistoryGrid::class);

?>
<!-- candidate details -->
<div class="row">
    <div class="col-12">
        <h5 class="text-info">Details for <strong>
                <?= $view->htmlEncode($candidate->name); ?>
            </strong></h5>
    </div>
    <div class="col-12">
        <?= $view->dataGrid($candidateGrid); ?>
    </div>
</div>
<!-- /candidate details -->

<!-- candidate imputed summary -->
<?php if (null !== $summaryGrid) { ?>
    <div class="row">
        <div class="col-12">
            <h5 class="text-info">Imputed totals</h5>
        </div>
        <div class="col-12">
            <?= $view->dataGrid($summaryGrid); ?>
        </div>
    </div>
<?php } ?>
<!-- /candidate imputed summary -->

<!-- candidate FEC summary -->
<div class="row">
    <div class="col-12">
        <h5 class="text-info">FEC report history</h5>
    </div>
    <div class="col-12">
        <?= $view->dataGrid($historyGrid); ?>
    </div>
</div>
<!-- /candidate FEC summary -->

<!-- download link -->
<?= $view->downloadLink($candidate->id); ?>
<!-- /download link -->
