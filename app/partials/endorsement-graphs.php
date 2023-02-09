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
$endorserId = (string)$response->getAttributeNullable('endorserId', '');
$endorsers = $response->getAttribute('endorsers', []);
$totalType = $response->getObject(TotalType::class);

if ('' !== $endorserId) { ?>
    <div class="row">
        <div class="col-12 col-lg-6">
            <?=

            $view->partial('graph', [
                Candidate::class => $candidate,
                'endorserId' => $endorserId,
                GraphType::class => new GraphType(GraphType::TYPE_COUNT),
                TotalType::class => $totalType
            ]);

            ?>
        </div>
        <div class="col-12 col-lg-6">
            <?=

            $view->partial('graph', [
                Candidate::class => $candidate,
                'endorserId' => $endorserId,
                GraphType::class => new GraphType(GraphType::TYPE_AMT),
                TotalType::class => $totalType
            ]);

            ?>
        </div>
    </div>
    <?php
}