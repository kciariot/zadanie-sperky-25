<?php

declare(strict_types=1);

use Services\MeowFactsService;
use Services\CurlRequesterService;
use Services\RequestHandlerService;
use Helpers\HtmlRenderHelper;
use Helpers\SanitizerHelper;
use Exceptions\ApiException;
use Dto\MeowFactParametersDto;

require 'src/Services/MeowFactsService.php';
require 'src/Services/CurlRequesterService.php';
require 'src/Services/RequestHandlerService.php';
require 'src/Helpers/SanitizerHelper.php';
require 'src/Helpers/HtmlRenderHelper.php';
require 'src/Exceptions/ApiException.php';
require 'src/Dto/MeowFactParametersDto.php';

/**
 * Ajax endpoint
 */
if (!empty($_GET['request'])) {
    echo RequestHandlerService::handle(SanitizerHelper::sanitizeString($_GET['request']));
    return;
}

/**
 * Site load
 */
$meowFactsService = new MeowFactsService();

/**
 * Get facts and render content
 */
try {
    $response = (new MeowFactsService())->getMeowFacts((new MeowFactParametersDto()));

    $content = HtmlRenderHelper::renderMeowFacts($response['data'] ?? []);
} catch (ApiException $e) {
    $response = CurlRequesterService::handleError($e);

    $content = HtmlRenderHelper::renderError($response['error']);
}

/**
 * Generate language options list for select
 */
$optionsList = array_merge(['' => '-- not selected --'], $meowFactsService::getThrowErrorLanguages(), $meowFactsService::getAllowedLanguages());

$optionsListContent = HtmlRenderHelper::renderOptionsList($optionsList);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zadanie šperky 25</title>
    <link rel="stylesheet" href="resources/styles/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-row-container">
                <label for="id">ID</label>
                <input type="number" id="id" name="id" min="1" onchange="validateMinNumber(this)" />
            </div>

            <div class="form-row-container">
                <label for="count">Count</label>
                <input type="number" id="count" name="count" min="1" onchange="validateMinNumber(this)" />
            </div>

            <div class="form-row-container">
                <label for="lang">Lang</label>
                <select id="lang" name="lang">
                    <?= $optionsListContent ?>
                </select>
            </div>

            <button type="button" onclick="getNewMeowFacts(this)">Send</button>

            <br>
            <span class="disclaimer">* Parameter "COUNT" overrides parameter "ID". If "COUNT" is set even to 1, "ID" will be ignored.</span>

            <br>
            <span class="disclaimer">* Slovak language is not supported by API. I added it only to simulate API error response.</span>

            <hr>
        </div>

        <div class="meow-facts-content">
            <?= $content ?>
        </div>
    </div>

    <script src="resources/js/scripts.js"></script>
</body>
</html>
