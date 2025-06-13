<?php

require 'src/API/MeowFacts.php';
require 'src/Services/Request.php';

if (!empty($_GET['request']) && $_GET['request'] === 'loadNewMeowFacts') {
    try {
        $response = (new \API\MeowFacts())->loadMeowFacts($_GET);
    } catch (Exception $e) {
        $response = \Services\Request::handleError($e);
    }

    echo json_encode($response);
    return;
}

$api = new \API\MeowFacts();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zadanie šperky 25</title>
    <link rel="stylesheet" href="public/styles/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-row-container">
                <label for="id">ID</label>
                <input type="text" id="id" name="id" />
            </div>

            <div class="form-row-container">
                <label for="count">Count</label>
                <input type="text" id="count" name="count" />
            </div>

            <div class="form-row-container">
                <label for="lang">Lang</label>
                <select id="lang" name="lang">
                    <?= $api->renderLanguageOptionsList() ?>
                </select>
            </div>

            <div class="form-row-container">
                <label for="no-validation">No validation</label>
                <input type="checkbox" name="no-validation" id="no-validation">
            </div>

            <button type="button" onclick="loadNewMeowFacts()">Send</button>
            <hr>
        </div>

        <div class="meow-facts-content">
            <?= $api->renderMeowFactsContent() ?>
        </div>
    </div>

    <script src="public/js/scripts.js"></script>
</body>
</html>
