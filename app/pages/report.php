<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Grids\CandidateGrid;
use CliffordVickrey\FecReporter\App\Grids\CandidateSubTotalsGrid;
use CliffordVickrey\FecReporter\App\Grids\CandidateSummaryGrid;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

header('Content-Type: text/html; charset=UTF-8');

$response = $response ?? new Response();
$view = $view ?? new View();

$candidates = $response->getObject(CandidateCollection::class);
$candidatesJson = $view->htmlEncode(json_encode($candidates));

$candidate = $response->getObject(Candidate::class);

$candidateGrid = null;
$summaryGrid = null;
$totalType = null;

if ($candidate->id !== '') {
    $candidateGrid = $response->getObject(CandidateGrid::class);
    $summaryGrid = $response->getObject(CandidateSummaryGrid::class);
    $totalType = $response->getObjectNullable(TotalType::class);
}

$subTotalsGrid = null;

if (null !== $totalType) {
    $subTotalsGrid = $response->getObject(CandidateSubTotalsGrid::class);
}

?>
<!-- reporting form -->
<form class="form" method="get" id="fec-form">
    <div class="container-fluid">
        <div class="row">
            <?= $view->autocomplete(
                'candidate-id',
                'candidateId',
                'Candidate',
                $candidates,
                $candidate->id,
                $candidate->name
            ); ?>
        </div>

        <!-- candidate selected -->
        <?php if ('' !== $candidate->id) { ?>
            <hr/>

            <!-- candidate details -->
            <?php if (null !== $candidateGrid) { ?>
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
            <?php } ?>
            <!-- /candidate details -->

            <!-- candidate FEC summary -->
            <?php if (null !== $summaryGrid) { ?>
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-info">Aggregate totals for <strong>
                                <?= $view->htmlEncode($candidate->name); ?>
                            </strong></h5>
                    </div>
                    <div class="col-12">
                        <?= $view->dataGrid($summaryGrid); ?>
                    </div>
                </div>
            <?php } ?>
            <!-- /candidate FEC summary -->

            <!-- reporting controls -->
            <?= $view->downloadLink($candidate->id); ?>
            <hr/>
            <div class="row">
                <div class="col-12">
                    <h5 class="text-info">Donor subtotals for <strong>
                            <?= $view->htmlEncode($candidate->name); ?>
                        </strong></h5>
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
            <!-- /reporting controls -->

            <!-- donor type selected -->
            <?php if (null !== $totalType && null !== $subTotalsGrid) { ?>
                <p class="pt-3">
                    <?= $view->htmlEncode($totalType->getBlurb()); ?>
                </p>
                <div class="row">
                    <div class="col-12">
                        <?= $view->dataGrid($subTotalsGrid); ?>
                    </div>
                </div>
                <?= $view->downloadLink($candidate->id, $totalType); ?>
            <?php } ?>
            <!-- /donor type selected -->
        <?php } ?>
        <!-- /candidate selected -->
    </div>
</form>
<!-- /reporting form -->

<!-- download form -->
<form class="d-none" method="get" id="fec-download-form">
    <input id="downloadCandidateId" autocomplete="off"<?= '' == $candidate->id
        ? ''
        : sprintf(' value="%s"', $view->htmlEncode($candidate->id)); ?>
           name="candidateId" type="hidden"/>
    <input type="hidden" name="downloadType" id="fec-download-type" autocomplete="off"/>
</form>
<!-- /download form -->