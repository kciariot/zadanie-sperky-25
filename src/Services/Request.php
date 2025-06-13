<?php

namespace Services;

use Exception;

class Request
{
    /**
     * Only get request is needed for project
     *
     * @throws Exception
     */
    public function sendGetRequest(string $url, array $params): array
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
            throw new Exception($response, $code);
        }

        curl_close($ch);

        return $res;
    }


    public static function handleError(Exception $e): array
    {
        http_response_code($e->getCode());

        return ['error' => $e->getMessage()];
    }
}