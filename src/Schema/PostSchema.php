<?php

namespace App\Schema;

use App\Dto\PostDto;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * JSON API schema for a post
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Schema
 */
class PostSchema extends SchemaProvider
{
    protected $resourceType = 'posts';

    /**
     * @param PostDto $resource
     *
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getId();
    }

    /**
     * @param PostDto $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [];
    }
}