<?php

declare(strict_types=1);

namespace Helpers;

class HtmlRenderHelper
{
    /**
     * Render option list for select tag
     *
     * @param array $options
     * @return string
     */
    public static function renderOptionsList(array $options): string
    {
        $optionsList = '';

        foreach ($options as $value => $title) {
            $optionsList .= "<option value='$value'>$title</option>";
        }

        return $optionsList;
    }

    /**
     * Render container element for meow fact content
     *
     * @param array $meowFacts
     * @return string
     */
    public static function renderMeowFacts(array $meowFacts): string
    {
        $meowFactsContent = '';

        foreach ($meowFacts as $meowFact) {
            $meowFactsContent .= "<div class='meow-fact'>$meowFact</div>";
        }

        return $meowFactsContent;
    }

    /**
     * Render container for error message
     *
     * @param string $errorMessage
     * @return string
     */
    public static function renderError(string $errorMessage): string
    {
        return "<div class='error'>$errorMessage</div>";
    }
}