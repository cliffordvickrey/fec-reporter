<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Grids\NonEndorsersGrid;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

$response = $response ?? new Response();
$view = $view ?? new View();

$candidate = $response->getObject(Candidate::class);
$totalType = $response->getObject(TotalType::class);
$nonEndorserId = (string)$response->getAttributeNullable('nonEndorserId', '');
$nonEndorsers = $response->getAttribute('nonEndorsers', []);

?>
<div class="row">
    <div class="col-12">
        <h5 class="text-info">Non-Endorsers
            (<?= $view->htmlEncode($totalType->getDownloadDescription()); ?>)
            of <strong><?= $view->htmlEncode($candidate->name); ?></strong></h5>
    </div>
</div>
<div class="row">
    <?= $view->autocomplete(
        'fec-non-endorsers-id',
        'nonEndorserId',
        'Non-Endorser',
        $nonEndorsers,
        $nonEndorserId
    ); ?>
</div>
<?php if ('' !== $nonEndorserId) {
    $nonEndorsersGrid = $response->getObject(NonEndorsersGrid::class);
    ?>
    <div class="row">
        <div class="col-12 py-3">
            <?= $view->dataGrid($nonEndorsersGrid); ?>
        </div>
    </div>
<?php } ?>
