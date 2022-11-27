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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>FEC Reporter</title>
</head>
<body>
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="col-12 mt-3">
                <div class="card">
                    <h5 class="card-header">FEC Reporter</h5>
                    <div class="card-body">
                        <form class="form" method="get" id="fec-form">
                            <input type="hidden" name="downloadType" id="fec-download-type" autocomplete="off"/>
                            <input type="hidden" name="candidateId" id="fec-candidate-id"<?=
                            '' === $candidate->id
                                ? ''
                                : sprintf(' value="%s"', $view->htmlEncode($candidate->id));
                            ?> autocomplete="off"/>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-text" id="fec-candidate-search-addon">
                                                Candidate
                                            </span>
                                            <input id="fec-candidate-search" data-candidates="<?= $candidatesJson; ?>"
                                                   aria-describedby="fec-candidate-search-addon" aria-label="Candidate"
                                                   class="form-control"<?=
                                                    '' === $candidate->name
                                                    ? ''
                                                    : sprintf(' value="%s"', $view->htmlEncode($candidate->name));
                                                    ?>>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <button class="btn btn-secondary mt-3 mt-lg-0" id="fec-clear">Clear</button>
                                    </div>
                                </div>
                                <?php if ('' !== $candidate->id) { ?>
                                    <!-- candidate selected -->

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

                                    <?php if (null !== $totalType && null !== $subTotalsGrid) { ?>
                                        <p class="pt-3">
                                            <?= $view->htmlEncode($totalType->getBlurb()); ?>
                                        </p>

                                        <!-- donor type selected -->
                                        <div class="row">
                                            <div class="col-12">
                                                <?= $view->dataGrid($subTotalsGrid); ?>
                                            </div>
                                        </div>
                                        <?= $view->downloadLink($candidate->id, $totalType); ?>
                                        <!-- /donor type selected -->
                                    <?php } ?>
                                    <!-- /candidate selected -->
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <small>Copyright &copy; 2022 Clifford Vickrey. All rights
                            reserved, all wrongs <em>avenged</em></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<!-- Credit: https://github.com/gch1p/bootstrap-5-autocomplete -->
<!--suppress HtmlUnknownTarget -->
<script src="js/typeahead.js"></script>
<!--suppress HtmlUnknownTarget -->
<script src="js/fec.js"></script>
</body>
</html>
