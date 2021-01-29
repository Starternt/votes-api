<?php

namespace App\Dto;

use Reva2\JsonApi\Annotations\ApiResource;
use Reva2\JsonApi\Annotations\Id;

/**
 * User DTO
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 *
 * @ApiResource(name="users")
 */
class UserDto
{
    /**
     * Post ID
     *
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
     * @return UserDto
     */
    public function setId(string $id): UserDto
    {
        $this->id = $id;

        return $this;
    }
}