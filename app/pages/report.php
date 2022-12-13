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
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="fec-accordion-heading-candidate">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fec-accordion-collapse-candidate" aria-expanded="true"
                                        aria-controls="fec-accordion-collapse-candidate">
                                    Candidate Info
                                </button>
                            </h2>
                            <div id="fec-accordion-collapse-candidate" class="accordion-collapse collapse show"
                                 aria-labelledby="fec-accordion-heading-candidate">
                                <div class="accordion-body">
                                    <div class="container-fluid">
                                        <!-- candidate info -->
                                        <?= $view->partial('candidate-info', $response); ?>
                                        <!-- /candidate info -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /candidate info panel -->
                        <!-- subtotals  panel -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="fec-accordion-heading-subtotals">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fec-accordion-collapse-subtotals" aria-expanded="true"
                                        aria-controls="fec-accordion-collapse-subtotals">
                                    Subtotals
                                </button>
                            </h2>
                            <div id="fec-accordion-collapse-subtotals" class="accordion-collapse collapse show"
                                 aria-labelledby="fec-accordion-heading-subtotals">
                                <div class="accordion-body">
                                    <div class="container-fluid">
                                        <!-- subtotals info -->
                                        <?= $view->partial('subtotals', $response); ?>
                                        <!-- /subtotals info -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /subtotals panel -->
                        <?php if (null !== $totalType) { ?>
                            <!-- endorsers panel -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="fec-accordion-heading-endorsers">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#fec-accordion-collapse-endorsers" aria-expanded="true"
                                            aria-controls="fec-accordion-collapse-endorsers">
                                        Endorsers
                                    </button>
                                </h2>
                                <div id="fec-accordion-collapse-endorsers" class="accordion-collapse collapse show"
                                     aria-labelledby="fec-accordion-heading-endorsers">
                                    <div class="accordion-body">
                                        <div class="container-fluid">
                                            <!-- endorsers info -->
                                            <?= $view->partial('endorsers', $response); ?>
                                            <!-- /endorsers info -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /endorsers panel -->
                            <!-- non-endorsers panel -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="fec-accordion-heading-non-endorsers">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#fec-accordion-collapse-non-endorsers" aria-expanded="true"
                                            aria-controls="fec-accordion-collapse-non-endorsers">
                                        Non-Endorsers
                                    </button>
                                </h2>
                                <div id="fec-accordion-collapse-non-endorsers" class="accordion-collapse collapse show"
                                     aria-labelledby="fec-accordion-heading-non-endorsers">
                                    <div class="accordion-body">
                                        <div class="container-fluid">
                                            <!-- non-endorsers info -->
                                            <?= $view->partial('non-endorsers', $response); ?>
                                            <!-- /non-endorsers info -->
                                        </div>
                                    </div>
                                </div>
                            </div>
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