<?php

namespace API;

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

        $meowFacts = $this->loadMeowFacts();

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

        $languages = array_merge(['svk' => 'Slovak (Not working)'], $this->allowedLanguages);

        foreach ($languages as $langCode => $langName) {
            $optionsList .= "<option value='$langCode'>$langName</option>";
        }

        return $optionsList;
    }

    private function validateLoadMeowFactsParameters(array $params): array
    {
        $validParams = [];

        if (!empty($params['id']) && is_numeric($params['id'])) {
            $parsedId = intval($params['id']);

            // Soft check to compare only value not type
            if ($parsedId == $params['id']) {
                $validParams['id'] = $parsedId;
            }
        }

        if (!empty($params['count']) && is_numeric($params['count'])) {
            $parsedCount = intval($params['count']);

            // Soft check to compare only value not type
            if ($parsedCount == $params['count']) {
                $validParams['count'] = $parsedCount;
            }
        }

        if (!empty($params['lang']) && ($params['lang'] === 'svk' || isset($this->allowedLanguages[$params['lang']]))) {
            $validParams['lang'] = $params['lang'];
        }

        return $validParams;
    }
}