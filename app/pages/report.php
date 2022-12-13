<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

$response = $response ?? new Response();
$view = $view ?? new View();

$candidates = $response->getObject(CandidateCollection::class);
$candidate = $response->getObject(Candidate::class);
$totalType = $response->getObjectNullable(TotalType::class);

?>
<!-- reporting form -->
<form class="form" method="get" id="fec-form">
    <div class="container-fluid">
        <div class="row">
            <?= $view->autocomplete(
                'fec-candidate-id',
                'candidateId',
                'Candidate',
                $candidates,
                $candidate->id,
                $candidate->name
            ); ?>
        </div>

        <?php if ('' !== $candidate->id) { ?>
            <div class="row">
                <div class="col-12">
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- panels -->
                    <div class="accordion" id="fec-accordion">
                        <!-- candidate info panel -->
                        <?= $view->panel(
                            'candidate',
                            'Candidate Info',
                            $view->partial('candidate', $response)
                        ); ?>
                        <!-- /candidate info panel -->
                        <!-- subtotals  panel -->
                        <?= $view->panel(
                            'subtotal',
                            'Subtotals',
                            $view->partial('subtotals', $response)
                        ); ?>
                        <!-- /subtotals panel -->
                        <?php if (null !== $totalType) { ?>
                            <!-- endorsers panel -->
                            <?= $view->panel(
                                'endorsers',
                                'Endorsers',
                                $view->partial('endorsers', $response)
                            ); ?>
                            <!-- /endorsers panel -->
                            <!-- non-endorsers panel -->
                            <?= $view->panel(
                                'non-endorsers',
                                'Non-Endorsers',
                                $view->partial('non-endorsers', $response)
                            ); ?>
                            <!-- /non-endorsers panel -->
                        <?php } ?>
                    </div>
                    <!-- /panels -->
                </div>
            </div>
        <?php } ?>
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