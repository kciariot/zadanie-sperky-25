<?php

declare(strict_types=1);

namespace Exceptions;

use Exception;

class ApiException extends Exception
{
    const CODES = [
        'PARAMETER_OUT_OF_BOUNDS' => 'The provided parameter value is outside the acceptable range. Please adjust it and try again.',
        'API_RESPONSE_ERROR' => 'An error occurred while processing your request. Please check the request parameters and try again.',
        'UNKNOWN_REQUEST' => 'Invalid request. The endpoint you are trying to reach does not exist or is improperly formatted.'
    ];

    /**
     * Parameter did not met required criteria
     *
     * @param string $parameterName
     * @return self
     */
    public static function parameterOutOfBounds(string $parameterName = ''): self
    {
        $message = self::CODES['PARAMETER_OUT_OF_BOUNDS'];

        if (!empty($parameterName)) {
            $message .= " => \"$parameterName\"";
        }

        return new self($message, 400);
    }

    /**
     * API response returned with error status code
     *
     * @param string $additionalInfo
     * @return self
     */
    public static function apiResponseError(string $additionalInfo = ''): self
    {
        $message = self::CODES['API_RESPONSE_ERROR'];

        if (!empty($additionalInfo)) {
            $message .= ": $additionalInfo";
        }

        return new self($message, 400);
    }

    /**
     * Unrecognized request parameter has been submitted
     *
     * @return self
     */
    public static function unknownRequest(): self
    {
        return new self(self::CODES['UNKNOWN_REQUEST'], 400);
    }
}