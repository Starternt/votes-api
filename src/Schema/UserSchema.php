<?php

namespace App\Schema;

use App\Dto\UserDto;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * JSON API schema for a user
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Schema
 */
class UserSchema extends SchemaProvider
{
    protected $resourceType = 'users';

    /**
     * @param UserDto $resource
     *
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getId();
    }

    /**
     * @param UserDto $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [];
    }
}