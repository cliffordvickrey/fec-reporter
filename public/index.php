<?php

/** @noinspection PhpUnusedParameterInspection */

declare(strict_types=1);

use CliffordVickrey\FecReporter\App\Controller\DownloadController;
use CliffordVickrey\FecReporter\App\Controller\IndexController;
use CliffordVickrey\FecReporter\App\Request\Request;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\App\View\View;
use CliffordVickrey\FecReporter\Domain\Repository\ObjectRepository;
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
        $controller = new DownloadController(new ObjectRepository());
    } else {
        $controller = new IndexController(new ObjectRepository());
    }

    $response = $controller->dispatch($request);
} catch (Throwable $ex) {
    error_log((string)$ex);
    $response = new Response();
    $response[Response::ATTR_PAGE] = 'error';
}

$content = null;

$layout = $response->getAttribute(Response::ATTR_LAYOUT, false);

if ($layout) {
    ob_start();
}

try {
    $page = CastingUtilities::toString($response[Response::ATTR_PAGE]);

    if ('' === $page) {
        throw new FecRuntimeException('Could not resolve page to go to');
    }

    $file = realpath(__DIR__ . "/../app/pages/$page.php");

    if (false === $file || !is_file($file)) {
        throw new FecRuntimeException("Invalid page, $page");
    }

    call_user_func(function (string $__file, Response $response, View $view) {
        include $__file;
    }, $file, $response, $view);
} finally {
    if ($layout) {
        $content = (string)ob_get_contents();
        ob_end_clean();
    }
}

if (null !== $content) {
    echo $view->partial('layout', [
        Response::ATTR_CONTENT => $content,
        Response::ATTR_JS => $response->getAttribute(Response::ATTR_JS, false)
    ]);
}
