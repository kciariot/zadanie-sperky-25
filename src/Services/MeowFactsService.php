<?php

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

    /**
     * @param MeowFactParametersDto $parameters
     * @return array
     * @throws ApiException
     */
    public function loadMeowFacts(MeowFactParametersDto $parameters): array
    {
        $validParameters = $this->validateLoadMeowFactsParameters($parameters);

        return CurlRequesterService::sendGetRequest(self::API_URL, $validParameters);
    }

    /**
     * Loads empty request and renders response to display meow fact on page load
     *
     * @return string
     */
    public function renderMeowFactsContent(): string
    {
        $content = '';

        try {
            $meowFacts = $this->loadMeowFacts(new MeowFactParametersDto());
        } catch (ApiException $e) {
            return "<div class='error'>{$e->getMessage()}</div>";
        }

        foreach ($meowFacts['data'] as $meowFact) {
            $content .= "<div class='meow-fact'>$meowFact</div>";
        }

        return $content;
    }

    /**
     * Renders options list for language select for meow facts api
     *  - SVK is added so we can simulate error message
     *
     * @return string
     */
    public function renderLanguageOptionsList(): string
    {
        $optionsList = '';

        $languages = array_merge(['' => '-- not selected --', 'svk' => 'Slovak (Not working)'], self::ALLOWED_LANGUAGES);

        foreach ($languages as $langCode => $langName) {
            $optionsList .= "<option value='$langCode'>$langName</option>";
        }

        return $optionsList;
    }

    /**
     * CurlRequesterService param validation
     *
     * @param MeowFactParametersDto $parameters
     * @return array
     * @throws ApiException
     */
    private function validateLoadMeowFactsParameters(MeowFactParametersDto $parameters): array
    {
        $validParameters = [];

        if ($parameters->getId() !== null) {
            $validParameters['id'] = $parameters->getId();
        }

        if ($parameters->getCount() !== null) {
            $validParameters['count'] = $parameters->getCount();
        }

        if ($parameters->getLang() !== null) {
            if ($parameters->getLang() !== 'svk' && !isset(self::ALLOWED_LANGUAGES[$parameters->getLang()])) {
                throw ApiException::parameterOutOfBounds('Lang');
            }

            $validParameters['lang'] = $parameters->getLang();
        }

        return $validParameters;
    }
}