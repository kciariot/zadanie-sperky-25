<?php

declare(strict_types=1);

namespace Helpers;

class SanitizerHelper
{
    /**
     * Sanitizes string to prevent injections (No db use, so I just put something there)
     *
     * @param string $input
     * @return string
     */
    public static function sanitizeString(string $input): string
    {
        return trim(htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8'));
    }
}