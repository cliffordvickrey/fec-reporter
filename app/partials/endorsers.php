<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Grids\EndorsersGrid;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

$response = $response ?? new Response();
$view = $view ?? new View();

$candidate = $response->getObject(Candidate::class);
$endorserId = (string)$response->getAttributeNullable('endorserId', '');
$endorsers = $response->getAttribute('endorsers', []);
$totalType = $response->getObject(TotalType::class);

?>
<div class="row">
    <div class="col-12">
        <h5 class="text-info">Endorsers
            (<?= $view->htmlEncode($totalType->getDownloadDescription()); ?>)
            of <strong><?= $view->htmlEncode($candidate->name); ?></strong></h5>
    </div>
    <?php if (0 === count($endorsers)) { ?>
        <div class="col-12">
            <p class="text-muted">This candidate didn't have any endorsement donors
                (<?= $view->htmlEncode($totalType->getDownloadDescription()); ?>)</p>
        </div>
    <?php } else { ?>
        <div class="col-12 col-lg-6">
            <?= $view->select(
                'fec-endorser',
                'endorserId',
                'Endorser',
                $endorsers,
                $endorserId
            ); ?>
        </div>
    <?php } ?>
</div>
<?php if ('' !== $endorserId) {
    $endorserName = $view->htmlEncode($endorsers[$endorserId]);

    $endorsersGrid = $response->getObject(EndorsersGrid::class);

    $endorsementDate = $view->htmlEncode($view->formatDate(
        $response->getAttribute('endorsementDate', new DateTimeImmutable())
    ));

    ?>
    <div class="row">
        <div class="col-12 py-3">
            <strong class="text-info"><?= $endorserName ?></strong> endorsed <strong
                    class="text-info"><?= $view->htmlEncode($candidate->name) ?></strong> on <?= $endorsementDate; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $view->dataGrid($endorsersGrid); ?>
        </div>
    </div>
<?php } ?>
