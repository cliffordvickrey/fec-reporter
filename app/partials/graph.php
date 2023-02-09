<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Enum\GraphType;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;

$response = $response ?? new Response();
$view = $view ?? new View();

$candidate = $response->getObject(Candidate::class);
$endorserId = $response->getAttribute('endorserId', '');
$graphType = $response->getObject(GraphType::class);
$totalType = $response->getObject(TotalType::class);

$src = sprintf('img/%s_to_%s-%s_%s.png', $endorserId, $candidate->id, strtoupper((string)$totalType), $graphType);

$desc = sprintf('%s (%s)', ucwords($graphType->getDescription()), $totalType->getDescription());

?>
<figure class="figure">
    <img src="<?= $view->htmlEncode($src); ?>" class="figure-img img-fluid rounded"
         alt="<?= $view->htmlEncode($desc); ?>">
    <figcaption class="figure-caption text-center"><?= $view->htmlEncode($desc); ?></figcaption>
</figure>
