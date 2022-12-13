<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Grids\CandidateSubTotalsGrid;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

$response = $response ?? new Response();
$view = $view ?? new View();

$candidate = $response->getObject(Candidate::class);
$totalType = $response->getObjectNullable(TotalType::class);

?>
    <!-- total type selection -->
    <div class="row">
        <div class="col-12">
            <h5 class="text-info">Donor subtotals for <strong><?= $view->htmlEncode($candidate->name); ?></strong></h5>
        </div>
        <div class="col-12 col-lg-6">
            <?= $view->select(
                'fec-total-type',
                'totalType',
                'Type of Donor',
                TotalType::getDropdownOptions(),
                (string)$totalType
            ); ?>
        </div>
    </div>
    <!-- /total type selection -->
<?php if (null !== $totalType) {
    $subTotalsGrid = $response->getObject(CandidateSubTotalsGrid::class);

    ?>
    <!-- subtotals -->
    <p class="pt-3">
        <?= $view->htmlEncode($totalType->getBlurb()); ?>
    </p>
    <div class="row">
        <div class="col-12">
            <?= $view->dataGrid($subTotalsGrid); ?>
        </div>
    </div>
    <?= $view->downloadLink($candidate->id, $totalType); ?>
    <!-- /subtotals -->
<?php } ?>
