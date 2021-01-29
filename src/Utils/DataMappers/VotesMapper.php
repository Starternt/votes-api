<?php

namespace App\Utils\DataMappers;

use App\Dto\PostDto;
use App\Dto\UserDto;
use App\Dto\VoteDto;
use App\Entity\Vote;
use Exception;

/**
 * Data mapper for votes
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Utils\DataMappers
 */
class VotesMapper
{
    /**
     * Convert DTO to vote entity
     *
     * @param VoteDto $voteDto
     *
     * @return Vote
     * @throws Exception
     */
    public function toEntity(VoteDto $voteDto): Vote
    {
        return (new Vote())
            ->setId($voteDto->getId())
            ->setPost($voteDto->getPost()->getId())
            ->setUser($voteDto->getCreatedBy()->getId())
            ->setIsNegative($voteDto->isNegative())
            ->setCreatedAt($voteDto->getCreatedAt());
    }

    /**
     * Convert vote entity to DTO
     *
     * @param Vote $vote
     *
     * @return VoteDto
     */
    public function toDto(Vote $vote): VoteDto
    {
        $createdBy = (new UserDto())->setId($vote->getId());
        $post = (new PostDto())->setId($vote->getPost());

        return (new VoteDto())
            ->setId($vote->getId())
            ->setPost($post)
            ->setCreatedBy($createdBy)
            ->setIsNegative($vote->isNegative())
            ->setCreatedAt($vote->getCreatedAt());
    }
}
