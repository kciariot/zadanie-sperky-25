<?php

declare(strict_types=1);

namespace Services;

use Exceptions\ApiException;

class CurlRequesterService
{
    /**
     * Sends GET request via CURL and process json response. Throws ApiException if server returned error.
     *
     * @param string $url
     * @param array $params
     * @return array
     * @throws ApiException
     */
    public static function sendGetRequest(string $url, array $params): array
    {
        $ch = curl_init();

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        curl_close($ch);

        if ($code >= 200 && $code < 300) {
            return ['data' => json_decode($response, true)['data'] ?? []];
        } else {
            throw ApiException::apiResponseError($response);
        }
    }

    /**
     * Handle ApiException and sets response code for front-end
     *
     * @param ApiException $e
     * @return array
     */
    public static function handleError(ApiException $e): array
    {
        http_response_code($e->getCode());

        return ['error' => $e->getMessage()];
    }
}