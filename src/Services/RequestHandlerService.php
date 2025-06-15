<?php

declare(strict_types=1);

namespace Services;

use Dto\MeowFactParametersDto;
use Exceptions\ApiException;

class RequestHandlerService
{
    public static function handle(string $requestFunction): string
    {
        try {
            $response = match ($requestFunction) {
                'getNewMeowFacts' => self::getNewMeowFacts(),
                default => self::unknowRequest()
            };
        } catch (ApiException $e) {
            $response = CurlRequesterService::handleError($e);
        }

        return json_encode($response);
    }

    /**
     * @throws ApiException
     */
    public static function getNewMeowFacts(): array
    {
        return (new MeowFactsService())->getMeowFacts((new MeowFactParametersDto())->getInstanceFromRequest());
    }

    /**
     * @throws ApiException
     */
    public static function unknowRequest(): array
    {
        throw ApiException::unknownRequest();
    }
}