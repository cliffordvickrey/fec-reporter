<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

$response = $response ?? new Response();
$view = $view ?? new View();

$totalType = $response->getObjectNullable(TotalType::class);
$totalTypeString = $totalType?->getValue() ?? 'cmte';

$desc = $totalType?->getDownloadDescription() ?? 'all donors';

?>
<div class="row">
    <div class="col-12">
        <a href="#" data-download="1" data-download-type="<?= $view->htmlEncode($totalTypeString) ?>">
            <?= $view->htmlEncode("Download data for $desc to this candidate"); ?>
        </a>
    </div>
</div>
