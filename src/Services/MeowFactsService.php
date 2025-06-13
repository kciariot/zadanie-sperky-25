<?php

declare(strict_types=1);

namespace Services;

use Dto\MeowFactParametersDto;
use Exceptions\ApiException;

class MeowFactsService
{
    const API_URL = 'https://meowfacts.herokuapp.com/';

    const ALLOWED_LANGUAGES = [
        'eng' => 'English',
        'ces' => 'Czech',
        'ger' => 'German',
        'ben' => 'Bengali',
        'esp' => 'Spanish',
        'rus' => 'Russian',
        'por' => 'Portuguese',
        'fil' => 'Filipino',
        'ukr' => 'Ukrainian',
        'urd' => 'Urdu',
        'ita' => 'Italian',
        'zho' => 'Chinese',
        'kor' => 'Korean'
    ];

    // Only to simulate error message
    const THROW_ERROR_LANGUAGE = [
        'svk' => 'Slovak (Throws API error)',
    ];

    // ID 0 gives random fact
    const MIN_VALUES = [
        'ID' => 1,
        'COUNT' => 1
    ];

    /**
     * Sends request to get new meow facts
     *
     * @param MeowFactParametersDto $parameters
     * @return array
     * @throws ApiException
     */
    public function getMeowFacts(MeowFactParametersDto $parameters): array
    {
        $validParameters = $this->validateMeowFactsParameters($parameters);

        return CurlRequesterService::sendGetRequest(self::API_URL, $validParameters);
    }

    /**
     * Only to simulate error message
     *
     * @return string[]
     */
    public static function getThrowErrorLanguages(): array
    {
        return self::THROW_ERROR_LANGUAGE;
    }

    /**
     * Returns languages currently supported by API provider
     *
     * @return string[]
     */
    public static function getAllowedLanguages(): array
    {
        return self::ALLOWED_LANGUAGES;
    }

    /**
     * CurlRequesterService param validation
     *
     * @param MeowFactParametersDto $parameters
     * @return array
     * @throws ApiException
     */
    private function validateMeowFactsParameters(MeowFactParametersDto $parameters): array
    {
        $validParameters = [];

        if ($parameters->getId() !== null) {
            if ($parameters->getId() < self::MIN_VALUES['ID']) {
                throw ApiException::parameterOutOfBounds('ID');
            }

            $validParameters['id'] = $parameters->getId();
        }

        if ($parameters->getCount() !== null) {
            if ($parameters->getCount() < self::MIN_VALUES['COUNT']) {
                throw ApiException::parameterOutOfBounds('COUNT');
            }

            $validParameters['count'] = $parameters->getCount();
        }

        if ($parameters->getLang() !== null) {
            if (!isset(self::THROW_ERROR_LANGUAGE[$parameters->getLang()]) && !isset(self::ALLOWED_LANGUAGES[$parameters->getLang()])) {
                throw ApiException::parameterOutOfBounds('LANG');
            }

            $validParameters['lang'] = $parameters->getLang();
        }

        return $validParameters;
    }
}