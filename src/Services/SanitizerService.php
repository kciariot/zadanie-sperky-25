<?php

namespace Services;

class SanitizerService
{
    public static function sanitizeString(string $input): string
    {
        return trim(htmlspecialchars(strip_tags($input), ENT_QUOTES, 'UTF-8'));
    }
}