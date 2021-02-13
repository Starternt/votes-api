<?php

namespace App\Service;

use App\Dto\UserDto;
use App\Dto\VoteDto;
use App\Entity\Vote;
use App\Utils\DataMappers\VotesMapper;
use App\Utils\KafkaHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Security;

/**
 * Service for posts
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Service
 */
class VotesService
{
    use KafkaHelper;

    /**
     * Entity manager interface
     *
     * @var EntityManager
     */
    protected $em;

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
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var Security
     */
    private $security;
    /**
     * @var string
     */
    private $votesTopic;

    /**
     * Constructor
     *
     * @param string $kafkaHost
     * @param string $kafkaPort
     * @param string $votesTopic
     * @param EntityManagerInterface $em
     * @param VotesMapper $mapper
     * @param Security $security
     */
    public function __construct(
        string $kafkaHost = '',
        string $kafkaPort = '',
        string $votesTopic = '',
        EntityManagerInterface $em,
        VotesMapper $mapper,
        Security $security
    ) {
        $this->em = $em;
        $this->mapper = $mapper;
        $this->kafkaHost = $kafkaHost;
        $this->kafkaPort = $kafkaPort;
        $this->repository = $em->getRepository(Vote::class);
        $this->security = $security;
        $this->votesTopic = $votesTopic;
    }

    /**
     * Returns vote with specified ID
     *
     * @param string $id
     *
     * @return null|Vote
     */
    public function find(string $id): ?Vote
    {
        /** @var Vote $vote */
        $vote = $this->repository->find($id);

        return $vote;
    }

    /**
     * Creates a vote. If user already voted for a specified post
     * then replace that vote by a new one.
     *
     * @param VoteDto $voteDto
     *
     * @return VoteDto
     * @throws Exception
     */
    public function create(VoteDto $voteDto): VoteDto
    {
        try {
            $producer = $this->configureProducer($this->kafkaHost, $this->kafkaPort);

            $this->em->beginTransaction();

            $vote = $this->mapper->toEntity($voteDto, $this->security->getUser());
            $existingVote = $this->repository->findOneBy(['user' => $vote->getUser(), 'post' => $vote->getPost()]);
            if ($existingVote) {
                $this->em->remove($existingVote);
                $this->em->flush($existingVote);
                $producer->send(
                    [
                        [
                            'topic' => $this->votesTopic,
                            'key'   => (string)$existingVote->getPost(),
                            'value' => $existingVote->isNegative() ? 'false' : 'true',
                        ],
                    ]
                );
            }

            $this->em->persist($vote);
            $this->em->flush();

            $this->em->commit();

            $producer->send(
                [
                    [
                        'topic' => $this->votesTopic,
                        'key'   => (string)$vote->getPost(),
                        'value' => $vote->isNegative() ? 'true' : 'false',
                    ],
                ]
            );

            return $this->mapper->toDto($vote);
        } catch (Exception $e) {
            $this->em->rollback();

            throw $e;
        }
    }

    /**
     * Delete a vote and send message to kafka
     *
     * @param Vote $vote
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Vote $vote)
    {
        try {
            $producer = $this->configureProducer($this->kafkaHost, $this->kafkaPort);

            $this->em->beginTransaction();

            $this->em->remove($vote);
            $this->em->flush();
            $this->em->commit();

            $producer->send(
                [
                    [
                        'topic' => $this->votesTopic,
                        'key'   => (string)$vote->getPost(),
                        'value' => $vote->isNegative() ? 'false' : 'true',
                    ],
                ]
            );
        } catch (Exception $e) {
            $this->em->rollback();

            throw $e;
        }
    }
}
