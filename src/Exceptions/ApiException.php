<?php

declare(strict_types=1);

namespace Exceptions;

use Exception;

class ApiException extends Exception
{
    const CODES = [
        'PARAMETER_OUT_OF_BOUNDS' => 'Parameter value is out of bound',
        'API_RESPONSE_ERROR' => 'API response error occurred'
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
}