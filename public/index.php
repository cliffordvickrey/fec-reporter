<?php

/** @noinspection PhpUnusedParameterInspection */

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Controller\DownloadController;
use CliffordVickrey\FecReporter\App\Controller\IndexController;
use CliffordVickrey\FecReporter\App\Request\Request;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Repository\CandidateCollectionRepository;
use CliffordVickrey\FecReporter\Domain\Repository\CandidateSummaryRepository;
use CliffordVickrey\FecReporter\Domain\Repository\TotalCollectionRepository;
use CliffordVickrey\FecReporter\Exception\FecRuntimeException;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);

chdir(__DIR__);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/error-handler.php';

set_error_handler('handleFecError'); // @phpstan-ignore-line

$view = new View();

try {
    $request = Request::fromSuperGlobals();

    if ($request->get(DownloadController::PARAM_DOWNLOAD_TYPE)) {
        $controller = new DownloadController(new CandidateCollectionRepository());
    } else {
        $controller = new IndexController(
            new CandidateCollectionRepository(),
            new CandidateSummaryRepository(),
            new TotalCollectionRepository(),
        );
    }

    $response = $controller->dispatch($request);
} catch (Throwable) {
    $response = new Response();
    $response[Response::ATTR_PAGE] = 'error';
}

call_user_func(static function (Response $response, View $view): void {
    $page = CastingUtilities::toString($response[Response::ATTR_PAGE]);

    if ('' === $page) {
        throw new FecRuntimeException('Could not resolve page to go to');
    }

    $file = realpath(__DIR__ . "/../app/pages/$page.php");

    if (false === $file || !is_file($file)) {
        throw new FecRuntimeException("Invalid page, $page");
    }

    include $file;
}, $response, $view);
