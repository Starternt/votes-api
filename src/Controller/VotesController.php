<?php

namespace App\Controller;

use App\Dto\VoteDto;
use App\Service\VotesService;
use App\Utils\JsonApi\JsonApiErrorsTrait;
use Exception;
use Psr\Log\LoggerInterface;
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
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var VotesService
     */
    protected $service;

    /**
     * @param JsonApiServiceInterface $jsonApiService
     * @param LoggerInterface $logger
     * @param VotesService $service
     */
    public function __construct(
        JsonApiServiceInterface $jsonApiService,
        LoggerInterface $logger,
        VotesService $service
    ) {
        parent::__construct($jsonApiService);

        $this->logger = $logger;
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

        /* @var $vote VoteDto */
        $vote = $apiRequest->getBody()->data;

        $voteDto = $this->service->create($vote);

        return $this->buildContentResponse($apiRequest, $voteDto);
    }
}
