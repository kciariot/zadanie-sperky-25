<?php

namespace Services;

use Exceptions\ApiException;

class CurlRequesterService
{
    /**
     * Only get request is needed for project
     *
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

        $res = [
            'code' => $code,
        ];

        if ($code >= 200 && $code < 300) {
            $res['data'] = json_decode($response, true)['data'] ?? [];
        } else {
            throw ApiException::apiResponseError($response);
        }

        curl_close($ch);

        return $res;
    }


    public static function handleError(ApiException $e): array
    {
        http_response_code($e->getCode());

        return ['error' => $e->getMessage()];
    }
}