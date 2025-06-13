<?php

namespace Exceptions;

use Exception;

class ApiException extends Exception
{
    const CODES = [
        'PARAMETER_OUT_OF_BOUNDS' => 'Parameter value is out of bound',
        'API_RESPONSE_ERROR' => 'API response error occurred'
    ];

    public static function parameterOutOfBounds(string $parameterName = ''): self
    {
        $message = self::CODES['PARAMETER_OUT_OF_BOUNDS'];

        if (!empty($parameterName)) {
            $message .= " => \"$parameterName\"";
        }

        return new self($message, 400);
    }

    public static function apiResponseError(string $additionalInfo = ''): self
    {
        $message = self::CODES['API_RESPONSE_ERROR'];

        if (!empty($additionalInfo)) {
            $message .= ": $additionalInfo";
        }

        return new self($message, 400);
    }
}