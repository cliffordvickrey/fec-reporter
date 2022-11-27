<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Controller;

use CliffordVickrey\FecReporter\App\Request\Request;
use CliffordVickrey\FecReporter\App\Response\Response;

interface ControllerInterface
{
    /**
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request): Response;
}
