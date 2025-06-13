<?php

namespace API;

use Exception;
use Services\Request;

class MeowFacts
{
    private string $url = 'https://meowfacts.herokuapp.com/';

    private array $allowedLanguages = [
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
     * @throws Exception
     */
    public function loadMeowFacts(array $params = []): array
    {
        $validParams = $this->validateLoadMeowFactsParameters($params);

        return (new Request())->sendGetRequest($this->url, $validParams);
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
            $meowFacts = $this->loadMeowFacts();
        } catch (Exception $e) {
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

        $languages = array_merge(['0' => '-- not selected --', 'svk' => 'Slovak (Not working)'], $this->allowedLanguages);

        foreach ($languages as $langCode => $langName) {
            $optionsList .= "<option value='$langCode'>$langName</option>";
        }

        return $optionsList;
    }

    /**
     * Request param validation
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    private function validateLoadMeowFactsParameters(array $params): array
    {
        $validParams = [];

        // Only for error handling test purposes
        if (!empty($params['no-validation'])) {
            if (!empty($params['id'])) {
                $validParams['id'] = $params['id'];
            }

            if (!empty($params['count'])) {
                $validParams['count'] = $params['count'];
            }

            if (!empty($params['lang'])) {
                $validParams['lang'] = $params['lang'];
            }

            return $validParams;
        }

        if (!empty($params['id'])) {
            if (!is_numeric($params['id'])) {
                throw new Exception('"ID" must be a number', 400);
            }

            $parsedId = intval($params['id']);

            // Soft check to compare only value not type
            if ($parsedId == $params['id']) {
                $validParams['id'] = $parsedId;
            } else {
                throw new Exception('"ID" must be an integer', 400);
            }
        }

        if (!empty($params['count'])) {
            if (!is_numeric($params['count'])) {
                throw new Exception('"Count" must be a number', 400);
            }

            $parsedCount = intval($params['count']);

            // Soft check to compare only value not type
            if ($parsedCount == $params['count']) {
                $validParams['count'] = $parsedCount;
            } else {
                throw new Exception('"Count" must be an integer', 400);
            }
        }

        if (!empty($params['lang'])) {
            if ($params['lang'] !== 'svk' && !isset($this->allowedLanguages[$params['lang']])) {
                throw new Exception('"Lang" value is not recognized', 400);
            }

            $validParams['lang'] = $params['lang'];
        }

        return $validParams;
    }
}