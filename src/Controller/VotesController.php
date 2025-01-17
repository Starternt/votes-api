<?php

namespace App\Controller;

use App\Dto\VoteDto;
use App\Service\VotesService;
use App\Utils\JsonApi\JsonApiErrorsTrait;
use Exception;
use Reva2\JsonApi\Annotations\ApiRequest;
use Reva2\JsonApi\Contracts\Services\JsonApiServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that implements votes API
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Controller
 */
class VotesController extends JsonApiController
{
    use JsonApiErrorsTrait;

    /**
     * @var VotesService
     */
    protected $service;

    /**
     * @param JsonApiServiceInterface $jsonApiService
     * @param VotesService $service
     */
    public function __construct(
        JsonApiServiceInterface $jsonApiService,
        VotesService $service
    ) {
        parent::__construct($jsonApiService);

        $this->service = $service;
    }

    /**
     * Create a vote
     *
     * @param Request $request
     *
     * @Route("/v1/votes", methods={"POST"}, name="votes.create")
     * @ApiRequest(
     *     query="App\Dto\VoteParams",
     *     body="App\Dto\VoteDocument",
     *     serialization={"Default", "CreateVote"}, validation={"Default", "CreateVote"}
     * )
     * @return Response
     * @throws Exception
     */
    public function create(Request $request): Response
    {
        $apiRequest = $this->jsonApiService->parseRequest($request);

        /* @var $voteDto VoteDto */
        $voteDto = $apiRequest->getBody()->data;

        $voteDto = $this->service->create($voteDto);

        return $this->buildContentResponse($apiRequest, $voteDto);
    }

    /**
     * Delete a vote with specified id
     *
     * @param Request $request
     * @param string $id
     *
     * @Route("/v1/votes/{id}", methods={"DELETE"}, name="votes.delete", requirements={"id"="[0-9a-zA-z-]+"})
     * @ApiRequest()
     *
     * @return Response
     * @throws Exception
     */
    public function delete(Request $request, string $id): Response
    {
        $vote = $this->service->find($id);
        if (null === $vote) {
            throw $this->createNotFoundException(sprintf("Vote #%d not found", $id));
        }

        $apiRequest = $this->jsonApiService->parseRequest($request);

        $this->service->delete($vote);

        return $this->buildEmptyResponse($apiRequest);
    }
}
