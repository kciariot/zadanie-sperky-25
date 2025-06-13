<?php

require 'src/Services/MeowFactsService.php';
require 'src/Services/CurlRequesterService.php';
require 'src/Services/SanitizerService.php';
require 'src/Dto/MeowFactParametersDto.php';
require 'src/Exceptions/ApiException.php';

if (!empty($_GET['request']) && $_GET['request'] === 'loadNewMeowFacts') {
    try {
        $meowFactsParameters = new \Dto\MeowFactParametersDto();

        if (!empty($_GET['id'])) {
            $meowFactsParameters->setId(intval($_GET['id']));
        }


        if (!empty($_GET['count'])) {
            $meowFactsParameters->setCount(intval($_GET['count']));
        }


        if (!empty($_GET['lang'])) {
            $meowFactsParameters->setLang(\Services\SanitizerService::sanitizeString($_GET['lang']));
        }

        $response = (new \Services\MeowFactsService())->loadMeowFacts($meowFactsParameters);
    } catch (Exception $e) {
        $response = \Services\CurlRequesterService::handleError($e);
    }

    echo json_encode($response);
    return;
}

$api = new \Services\MeowFactsService();

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
                <input type="number" id="id" name="id" min="0" />
            </div>

            <div class="form-row-container">
                <label for="count">Count</label>
                <input type="number" id="count" name="count" min="1" />
            </div>

            <div class="form-row-container">
                <label for="lang">Lang</label>
                <select id="lang" name="lang">
                    <?= $api->renderLanguageOptionsList() ?>
                </select>
            </div>

            <button type="button" onclick="loadNewMeowFacts(this)">Send</button>
            <hr>
        </div>

        <div class="meow-facts-content">
            <?= $api->renderMeowFactsContent() ?>
        </div>
    </div>

    <script src="resources/js/scripts.js"></script>
</body>
</html>
