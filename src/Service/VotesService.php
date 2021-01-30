<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Dto\VoteDto;
use App\Utils\DataMappers\VotesMapper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Service for posts
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Service
 */
class VotesService
{
    /**
     * Entity manager interface
     *
     * @var EntityManager
     */
    protected $em;

    /**
     * Event dispatcher
     *
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var VotesMapper
     */
    protected $mapper;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     * @param LoggerInterface $logger
     * @param VotesMapper $mapper
     */
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        LoggerInterface $logger,
        VotesMapper $mapper
    ) {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
        $this->mapper = $mapper;
    }

    /**
     * @param VoteDto $voteDto
     *
     * @return VoteDto
     * @throws Exception
     */
    public function create(VoteDto $voteDto): VoteDto
    {
        try {
            $this->em->beginTransaction();

            $createdBy = (new UserDto())->setId(Uuid::uuid4()); // TODO remove after auth realization
            $voteDto->setCreatedBy($createdBy);

            $vote = $this->mapper->toEntity($voteDto);

            $this->em->persist($vote);
            $this->em->flush();

            $this->em->commit();

            return $this->mapper->toDto($vote);
        } catch (Exception $e) {
            $this->em->rollback();

            throw $e;
        }
    }
}
