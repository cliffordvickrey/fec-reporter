<?php

declare(strict_types=1);

namespace CliffordVickrey\FecReporter\App\Controller;

use CliffordVickrey\FecReporter\App\Grids\CandidateGrid;
use CliffordVickrey\FecReporter\App\Grids\CandidateSubTotalsGrid;
use CliffordVickrey\FecReporter\App\Grids\CandidateSummaryGrid;
use CliffordVickrey\FecReporter\App\Grids\EndorsersGrid;
use CliffordVickrey\FecReporter\App\Grids\FecHistoryGrid;
use CliffordVickrey\FecReporter\App\Request\Request;
use CliffordVickrey\FecReporter\App\Response\Response;
use CliffordVickrey\FecReporter\Domain\Aggregate\EndorsersAggregate;
use CliffordVickrey\FecReporter\Domain\Collection\CandidateCollection;
use CliffordVickrey\FecReporter\Domain\Collection\CommitteeCollection;
use CliffordVickrey\FecReporter\Domain\Collection\TotalCollection;
use CliffordVickrey\FecReporter\Domain\Entity\Candidate;
use CliffordVickrey\FecReporter\Domain\Entity\CandidateSummary;
use CliffordVickrey\FecReporter\Domain\Enum\TotalType;
use CliffordVickrey\FecReporter\Domain\Repository\ObjectRepositoryInterface;
use CliffordVickrey\FecReporter\Infrastructure\Utility\CastingUtilities;

final class IndexController implements ControllerInterface
{
    public const PARAM_ENDORSER_ID = 'endorserId';
    public const PARAM_CANDIDATE_ID = 'candidateId';
    public const PARAM_TOTAL_TYPE = 'totalType';

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
        $response = new Response();

        $response[Response::ATTR_JS] = true;
        $response[Response::ATTR_PAGE] = 'report';

        // region candidates list

        $candidates = $this->objectRepository->getObject(CandidateCollection::class);
        $response[CandidateCollection::class] = $candidates;

        // endregion

        // region resolve candidate

        $candidateId = CastingUtilities::toString($request->get(self::PARAM_CANDIDATE_ID));

        if (!isset($candidates[$candidateId])) {
            $candidateId = '';
        }

        $candidate = '' === $candidateId ? (new Candidate()) : $candidates[$candidateId];

        $response[Candidate::class] = $candidate;

        if ('' === $candidateId) {
            return $response;
        }

        // endregion

        // region candidate-level info

        $candidateGrid = new CandidateGrid();
        $candidateGrid->setValues($candidate->toArray());
        $response[CandidateGrid::class] = $candidateGrid;

        $summary = $this->objectRepository->getObject(CandidateSummary::class, $candidateId);
        $summaryGrid = new CandidateSummaryGrid();
        $summaryGrid->setValues($summary->toArray());
        $response[CandidateSummaryGrid::class] = $summaryGrid;

        $committees = $this->objectRepository->getObject(CommitteeCollection::class);
        $presCommittee = $committees["{$candidateId}_pres"];

        $historyGrid = new FecHistoryGrid();
        $historyGrid->setValues($presCommittee->toArray());
        $response[FecHistoryGrid::class] = $historyGrid;

        // endregion

        // region donor profile

        $totalType = new TotalType($request->get(self::PARAM_TOTAL_TYPE), false);

        if ($totalType->isValid()) {
            // region subtotals

            $response[TotalType::class] = $totalType;

            $totalCollection = $this->objectRepository->getObject(TotalCollection::class, $candidateId);
            $subTotals = $totalCollection[$totalType];

            $subTotalsGrid = new CandidateSubTotalsGrid();
            $subTotalsGrid->setValues($subTotals->toArray());
            $response[CandidateSubTotalsGrid::class] = $subTotalsGrid;

            // endregion

            // region endorsers

            $endorsersAggregate = $this->objectRepository->getObject(EndorsersAggregate::class);
            $endorsers = $endorsersAggregate->getEndorsersList($candidateId, $totalType);
            $response['endorsers'] = $endorsers;

            $endorserId = CastingUtilities::toString($request->get(self::PARAM_ENDORSER_ID));

            if (!isset($endorsers[$endorserId])) {
                $endorserId = '';
            }

            $response[self::PARAM_ENDORSER_ID] = $endorserId;

            if ('' !== $endorsers) {
                $endorsements = $endorsersAggregate->getEndorserCommittees(
                    $candidateId,
                    $endorserId,
                    $totalType
                );

                $endorsersGrid = new EndorsersGrid();
                $endorsersGrid->setValues($endorsements);

                $response[EndorsersGrid::class] = $endorsersGrid;
                $response['endorsementDate'] = $endorsersAggregate->getEndorsementDate($candidateId, $endorserId);
            }

            // endregion
        }

        // endregion

        return $response;
    }
}
