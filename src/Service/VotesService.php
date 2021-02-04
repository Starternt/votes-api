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
     * @var string
     */
    protected $kafkaHost;

    /**
     * @var string
     */
    protected $kafkaPort;

    /**
     * Constructor
     *
     * @param string $kafkaHost
     * @param string $kafkaPort
     * @param EntityManagerInterface $em
     * @param EventDispatcherInterface $dispatcher
     * @param LoggerInterface $logger
     * @param VotesMapper $mapper
     */
    public function __construct(
        string $kafkaHost,
        string $kafkaPort,
        EntityManagerInterface $em,
        EventDispatcherInterface $dispatcher,
        LoggerInterface $logger,
        VotesMapper $mapper
    ) {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
        $this->mapper = $mapper;
        $this->kafkaHost = $kafkaHost;
        $this->kafkaPort = $kafkaPort;
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
            $config = \Kafka\ProducerConfig::getInstance();
            $config->setMetadataRefreshIntervalMs(100000);
            $config->setMetadataBrokerList($this->kafkaHost.':'.$this->kafkaPort);
            $config->setBrokerVersion('1.0.0');
            $config->setRequiredAck(1);

            $config->setIsAsyn(false);
            $producer = new \Kafka\Producer();

            $this->em->beginTransaction();

            $createdBy = (new UserDto())->setId(Uuid::uuid4()); // TODO remove after auth realization
            $voteDto->setCreatedBy($createdBy);

            $vote = $this->mapper->toEntity($voteDto);

            $this->em->persist($vote);
            $this->em->flush();

            $this->em->commit();

            $producer->send(
                [
                    [
                        'topic' => 'votes', // todo make ENV
                        'key'   => (string)$vote->getId(),
                        'value' => $vote->isNegative() ? 'true' : 'false',
                    ],
                ]
            );

            return $this->mapper->toDto($vote);
        } catch (Exception $e) {
            // todo add logging
            $this->em->rollback();

            throw $e;
        }
    }
}
