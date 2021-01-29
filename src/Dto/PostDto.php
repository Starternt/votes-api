<?php

namespace App\Dto;

use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Id;

/**
 * Post DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="posts")
 */
class PostDto
{
    /**
     * @var string
     * @Id()
     */
    protected $id;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return PostDto
     */
    public function setId(string $id): PostDto
    {
        $this->id = $id;

        return $this;
    }
}