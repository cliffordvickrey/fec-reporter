<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\Infrastructure\Utility;

use CliffordVickrey\FecReporter\Exception\FecRuntimeException;

use function file_get_contents;
use function is_file;
use function realpath;
use function sprintf;

class FileUtilities
{
    /**
     * @param string $filename
     * @return string
     */
    public static function fileGetContents(string $filename): string
    {
        if (!self::fileExists($filename)) {
            $msg = sprintf('File %s does not exist', $filename);
            throw new FecRuntimeException($msg);
        }

        $contents = file_get_contents($filename);

        if (false === $contents) {
            $msg = sprintf('Could not open %s', $filename);
            throw new FecRuntimeException($msg);
        }

        return $contents;
    }

    /**
     * @param string $filename
     * @return bool
     */
    public static function fileExists(string $filename): bool
    {
        return is_file($filename);
    }

    /**
     * @param string $path
     * @return string
     */
    public static function absoluteCanonicalPath(string $path): string
    {
        $absoluteCanonicalPath = realpath($path);

        if (false === $absoluteCanonicalPath) {
            $msg = sprintf('Could not resolve path to %s', $path);
            throw new FecRuntimeException($msg);
        }

        return $absoluteCanonicalPath;
    }
}
