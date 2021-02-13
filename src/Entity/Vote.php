<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Reva2\JsonApi\Annotations\Id;

/**
 * Vote entity
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="posts_votes")
 */
class Vote
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     * @Id()
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", name="postId", length=36)
     */
    protected $post;

    /**
     * @var bool
     * @ORM\Column(type="boolean", name="isNegative")
     */
    protected $isNegative = false;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime_immutable", name="createdAt")
     */
    protected $createdAt;

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
     * @return Vote
     */
    public function setId(string $id): Vote
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Vote
     */
    public function setUser(User $user): Vote
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getPost(): string
    {
        return $this->post;
    }

    /**
     * @param string $post
     *
     * @return Vote
     */
    public function setPost(string $post): Vote
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
     * @return Vote
     */
    public function setIsNegative(bool $isNegative): Vote
    {
        $this->isNegative = $isNegative;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     *
     * @return Vote
     */
    public function setCreatedAt(DateTimeInterface $createdAt): Vote
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
