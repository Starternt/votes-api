<?php

namespace App\Utils\JsonApi;

use Exception;
use Neomerx\JsonApi\Contracts\Document\ErrorInterface;
use Neomerx\JsonApi\Document\Error;
use Neomerx\JsonApi\Exceptions\JsonApiException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

/**
 * Helper for JSON API errors
 *
 * @package App\Utils\JsonApi
 */
trait JsonApiErrorsTrait
{
    /**
     * Creates JSON API error
     *
     * @param string $status
     * @param string $code
     * @param string $title
     * @param string|null $details
     * @param array|null $source
     *
     * @return ErrorInterface
     * @throws Exception
     */
    protected function createJsonApiError(
        string $status,
        string $code,
        string $title,
        ?string $details = null,
        ?array $source = null
    ): ErrorInterface {
        return new Error(
            Uuid::uuid4()->toString(),
            null,
            $status,
            $code,
            $title,
            $details,
            $source
        );
    }

    /**
     * Creates JSON API resource not found exception
     *
     * @param string|null $details
     * @param array|null $source
     *
     * @return JsonApiException
     * @throws Exception
     */
    protected function createNotFoundException(?string $details = null, ?array $source = null): JsonApiException
    {
        $error = $this->createJsonApiError(
            (string)Response::HTTP_NOT_FOUND,
            '110dc104-842a-425e-99eb-2d4e68aeed0b',
            'Resource not found',
            $details,
            $source
        );

        return new JsonApiException($error, Response::HTTP_NOT_FOUND);
    }
}