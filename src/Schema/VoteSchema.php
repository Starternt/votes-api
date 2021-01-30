<?php

namespace App\Schema;

use App\Dto\VoteDto;
use Neomerx\JsonApi\Schema\SchemaProvider;

/**
 * JSON API schema for a vote
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Schema
 */
class VoteSchema extends SchemaProvider
{
    protected $resourceType = 'votes';

    /**
     * @param VoteDto $resource
     *
     * @return string
     */
    public function getId($resource): string
    {
        return (string)$resource->getId();
    }

    /**
     * @param VoteDto $resource
     *
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'isNegative' => $resource->isNegative(),
            'createdAt'  => $resource->getCreatedAt()->format(DATE_ATOM),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRelationships($resource, $isPrimary, array $includeRelationships): array
    {
        /* @var $resource VoteDto */
        $relationships = [];
        if (in_array('createdBy', $includeRelationships)) {
            $relationships = [
                'createdBy' => [self::DATA => $resource->getCreatedBy()],
            ];
        }

        if (in_array('post', $includeRelationships)) {
            $relationships = [
                'post' => [self::DATA => $resource->getPost()],
            ];
        }

        return $relationships;
    }
}