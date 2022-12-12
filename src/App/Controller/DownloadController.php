<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Controller;

use CliffordVickrey\FecReporter\App\Request\Request;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Domain\Repository\ObjectRepositoryInterface;
use CliffordVickrey\FecReporter\Exception\FecInvalidArgumentException;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;
use CliffordVickrey\FecReporter\Infrastructure\Utility\FileUtilities;

use function sprintf;
use function strtoupper;

final class DownloadController implements ControllerInterface
{
    public const PARAM_DOWNLOAD_TYPE = 'downloadType';
    public const ATTRIBUTE_FILENAME = 'filename';

    /**
     * @param ObjectRepositoryInterface $objectRepository
     */
    public function __construct(private ObjectRepositoryInterface $objectRepository)
    {
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request): Response
    {
        $candidateId = CastingUtilities::toString($request->get(IndexController::PARAM_CANDIDATE_ID));

        if ('' === $candidateId) {
            throw new FecInvalidArgumentException('No candidate ID passed');
        }

        $candidateCollection = $this->objectRepository->getObject(CandidateCollection::class);

        if (!$candidateCollection->offsetExists($candidateId)) {
            $msg = sprintf('Candidate ID "%d" is invalid', $candidateId);
            throw new FecInvalidArgumentException($msg);
        }

        $type = new TotalType($request->get(self::PARAM_DOWNLOAD_TYPE), false);

        $response = new Response();
        $filename = self::getZipFilename($candidateId, $type, true);
        $response[Response::ATTR_LAYOUT] = false;
        $response[Response::ATTR_PAGE] = 'download';
        $response[self::ATTRIBUTE_FILENAME] = $filename;
        return $response;
    }

    /**
     * @param string $candidateId
     * @param TotalType|null $totalType
     * @param bool $absolute
     * @return non-empty-string|null
     */
    public static function getZipFilename(
        string $candidateId,
        ?TotalType $totalType = null,
        bool $absolute = false
    ): ?string {
        $typeSlug = 'CMTE';

        if (null !== $totalType && $totalType->isValid()) {
            $typeSlug = strtoupper((string)$totalType);
        }

        $filename = __DIR__ . "/../../../data/zip/{$typeSlug}_$candidateId.zip";

        if (FileUtilities::fileExists($filename)) {
            $filename = $absolute ? FileUtilities::absoluteCanonicalPath($filename) : $filename;

            if ('' !== $filename) {
                return $filename;
            }
        }

        return null;
    }
}
