<?php

namespace App\Dto;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Ramsey\Uuid\Uuid;
use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Attribute;
use Reva2\JsonApi\Annotations\Id;
use Reva2\JsonApi\Annotations\Relationship;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vote DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="votes")
 */
class VoteDto
{
    /**
     * @var string
     * @Id()
     */
    protected $id;

    /**
     * @var PostDto
     * @Assert\NotBlank()
     * @Relationship(type="App\Dto\PostDto")
     */
    protected $post;

    /**
     * @var boolean
     * @Assert\NotNull()
     * @Attribute()
     */
    protected $isNegative = false;

    /**
     * @var UserDto
     */
    protected $createdBy;

    /**
     * @var DateTimeInterface
     */
    protected $createdAt;

    /**
     * PostDto constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $this->id = Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return VoteDto
     */
    public function setId(string $id): VoteDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return PostDto
     */
    public function getPost(): PostDto
    {
        return $this->post;
    }

    /**
     * @param PostDto $post
     *
     * @return VoteDto
     */
    public function setPost(PostDto $post): VoteDto
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        return $this->isNegative;
    }

    /**
     * @param bool $isNegative
     *
     * @return VoteDto
     */
    public function setIsNegative(bool $isNegative): VoteDto
    {
        $this->isNegative = $isNegative;

        return $this;
    }

    /**
     * @return UserDto|null
     */
    public function getCreatedBy(): ?UserDto
    {
        return $this->createdBy;
    }

    /**
     * @param UserDto $createdBy
     *
     * @return VoteDto
     */
    public function setCreatedBy(UserDto $createdBy): VoteDto
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return VoteDto
     */
    public function setCreatedAt(DateTimeInterface $createdAt): VoteDto
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}