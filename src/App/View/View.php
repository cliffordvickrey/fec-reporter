<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\View;

use CliffordVickrey\FecReporter\App\Controller\DownloadController;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Exception\FecRuntimeException;
use CliffordVickrey\FecReporter\Infrastructure\Grid\AbstractGrid;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

use function htmlentities;
use function ob_end_clean;
use function ob_get_contents;
use function ob_start;
use function sprintf;

use const ENT_QUOTES;

class View
{
    /**
     * @param mixed $value
     * @return string
     */
    #[Pure]
    public function htmlEncode(mixed $value): string
    {
        $value = CastingUtilities::toString($value);
        return htmlentities($value, ENT_QUOTES);
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $label
     * @param array<array-key, string> $options
     * @param int|string|null $value
     * @return string
     */
    public function select(
        string $id,
        string $name,
        string $label,
        array $options,
        int|string|null $value = null
    ): string {
        $partialOptions = [
            'id' => $id,
            'name' => $name,
            'label' => $label,
            'options' => $options
        ];

        if (null !== $value) {
            $partialOptions['value'] = $value;
        }

        return $this->partial('select', $partialOptions);
    }

    /**
     * @param string $partial
     * @param array<string, mixed> $params
     * @return string
     */
    public function partial(string $partial, array $params): string
    {
        $filename = __DIR__ . "/../../../app/partials/$partial.php";

        if (!FileUtilities::fileExists($filename)) {
            $msg = sprintf('Partial "%s" does not exist', $partial);
            throw new FecRuntimeException($msg);
        }

        $response = new Response();

        foreach ($params as $k => $v) {
            $response[$k] = $v;
        }

        try {
            ob_start();
            require $filename;
            return (string)ob_get_contents();
        } finally {
            ob_end_clean();
        }
    }

    /**
     * @param string $id
     * @param string $name
     * @param string $label
     * @param array<array-key, string>|JsonSerializable $options
     * @param int|string|null $value
     * @param string|null $text
     * @return string
     */
    public function autocomplete(
        string $id,
        string $name,
        string $label,
        array|JsonSerializable $options,
        int|string|null $value = null,
        ?string $text = null
    ): string {
        $partialOptions = [
            'id' => $id,
            'name' => $name,
            'label' => $label,
            'options' => $options,
            'text' => $text
        ];

        if (null !== $value) {
            $partialOptions['value'] = $value;
        }

        return $this->partial('autocomplete', $partialOptions);
    }

    /**
     * @param AbstractGrid $grid
     * @return string
     */
    public function dataGrid(AbstractGrid $grid): string
    {
        return $this->partial('grid', [AbstractGrid::class => $grid]);
    }

    /**
     * @param non-empty-string $candidateId
     * @param TotalType|null $totalType
     * @return string
     */
    public function downloadLink(string $candidateId, ?TotalType $totalType = null): string
    {
        $filename = DownloadController::getZipFilename($candidateId, $totalType);

        if (null === $filename) {
            return '';
        }

        return $this->partial('download-link', [TotalType::class => $totalType]);
    }
}
