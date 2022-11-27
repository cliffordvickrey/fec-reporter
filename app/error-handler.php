<?php

declare(strict_types=1);

/**
 * @param int $severity
 * @param string $message
 * @param string|null $file
 * @param int|null $line
 * @return void
 * @throws ErrorException
 */
function handleFecError(int $severity, string $message, ?string $file, ?int $line): void
{
    if (!(error_reporting() & $severity)) {
        return;
    }

    throw new ErrorException($message, 0, $severity, $file, $line);
}
