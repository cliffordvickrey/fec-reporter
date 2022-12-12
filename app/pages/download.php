<?php

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Controller\DownloadController;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\Exception\FecRuntimeException;

$response = $response ?? new Response();

$filename = $response->getAttribute(DownloadController::ATTRIBUTE_FILENAME, '');

$ptr = fopen($filename, 'r');

if (false === $ptr) {
    throw new FecRuntimeException("Could not open $filename as resource");
}

$fStat = fstat($ptr);

if (false === $fStat) {
    throw new FecRuntimeException("Could not get the size of $filename");
}

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . rawurlencode(basename($filename)) . '"');
header('Content-Length: ' . $fStat['size']);

fpassthru($ptr);
