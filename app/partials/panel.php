<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;

$response = $response ?? new Response();
$view = $view ?? new View();

$id = $view->htmlEncode($response->getAttribute('id', ''));
$label = $view->htmlEncode($response->getAttribute('label', ''));

?>
<div class="accordion-item">
    <h2 class="accordion-header" id="fec-accordion-heading-<?= $id; ?>">
        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#fec-accordion-collapse-<?= $id; ?>" aria-expanded="true"
                aria-controls="fec-accordion-collapse-<?= $id; ?>">
            <?= $label; ?>
        </button>
    </h2>
    <div id="fec-accordion-collapse-<?= $id; ?>" class="accordion-collapse collapse show"
         aria-labelledby="fec-accordion-heading-<?= $id; ?>">
        <div class="accordion-body">
            <div class="container-fluid">
                <!-- pane content -->
                <?= $response->getAttribute('content', ''); ?>
                <!-- /pane content -->
            </div>
        </div>
    </div>
</div>
