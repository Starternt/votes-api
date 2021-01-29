<?php

namespace App\Utils\JsonApi;

use Exception;
use Neomerx\JsonApi\Contracts\Document\ErrorInterface;
use Neomerx\JsonApi\Document\Error;
use Neomerx\JsonApi\Exceptions\JsonApiException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

/**
 * Helper for JSON API errors generation
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
     * Creates bad request exception
     *
     * @param string|null $details
     * @param array|null $source
     *
     * @return JsonApiException
     * @throws Exception
     */
    protected function createBadRequestException(?string $details = null, ?array $source = null): JsonApiException
    {
        $error = $this->createJsonApiError(
            (string)Response::HTTP_BAD_REQUEST,
            '8029b35a-15b3-44ac-9707-6fe2f2f50aae',
            'Bad resource',
            $details,
            $source
        );

        return new JsonApiException($error, Response::HTTP_BAD_REQUEST);
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
            '690cdebd-d33a-4aa6-aca3-759d33d499d4',
            'Resource not found',
            $details,
            $source
        );

        return new JsonApiException($error, Response::HTTP_NOT_FOUND);
    }

    /**
     * Creates access denied exception
     *
     * @param string|null $details
     * @param array|null $source
     *
     * @return JsonApiException
     * @throws Exception
     */
    protected function createAccessDeniedException(?string $details = null, ?array $source = null): JsonApiException
    {
        $error = $this->createJsonApiError(
            (string)Response::HTTP_FORBIDDEN,
            'e5573881-e532-4657-beae-bc6f8c0d7658',
            'Access denied',
            $details,
            $source
        );

        return new JsonApiException($error, Response::HTTP_FORBIDDEN);
    }

    /**
     * Create conflict exception
     *
     * @param string|null $details
     * @param array|null $source
     *
     * @return JsonApiException
     * @throws Exception
     */
    protected function createConflictException(?string $details = null, ?array $source = null): JsonApiException
    {
        $error = $this->createJsonApiError(
            (string)Response::HTTP_CONFLICT,
            '32351f01-58c3-49b2-b1b8-217103e40b58',
            'Conflict with the current state of the target resource',
            $details,
            $source
        );

        return new JsonApiException($error, Response::HTTP_CONFLICT);
    }
}