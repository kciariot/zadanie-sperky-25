<?php

require '../src/API/MeowFacts.php';
require '../src/Services/Request.php';

if (!empty($_GET['request']) && $_GET['request'] === 'loadNewMeowFacts') {
    $response = (new \API\MeowFacts())->loadMeowFacts($_GET);

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
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="input-container">
                <label for="id">ID</label>
                <input type="text" id="id" name="id" />
            </div>

            <div class="input-container">
                <label for="count">Count</label>
                <input type="text" id="count" name="count" />
            </div>

            <div class="input-container">
                <label for="lang">Lang</label>
                <select id="lang" name="lang">
                    <?= $api->renderLanguageOptionsList() ?>
                </select>
            </div>

            <button type="button" onclick="loadNewMeowFacts()">Send</button>
        </div>

        <div class="meow-facts-content">
            <?= $api->renderMeowFactsContent() ?>
        </div>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>
