<?php

namespace App\Dto;

use Reva2\JsonApi\Http\Query\QueryParameters;

/**
 * Query parameters for endpoint that returns information about
 * specified vote
 *
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Dto
 */
class VoteParams extends QueryParameters
{
    /**
     * @inheritdoc
     */
    protected function getAllowedIncludePaths()
    {
        return [
            'post',
            'createdBy',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getAllowedFields($resource)
    {
        switch ($resource) {
            case 'votes':
                return [
                    'id',
                    'isNegative'
                ];

            default:
                return parent::getFieldSets();
        }
    }
}
