<?php

require '../src/API/MeowFacts.php';
require '../src/Services/Request.php';

$content = '';
$optionsList = '';

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="input-container">
                <label for="id">ID</label>
                <input type="number" id="id" name="id" min="0" />
            </div>

            <div class="input-container">
                <label for="count">Count</label>
                <input type="number" id="count" name="count" min="1" />
            </div>

            <div class="input-container">
                <label for="lang">Lang</label>
                <select id="lang" name="lang">
                    <?= $optionsList ?>
                </select>
            </div>

            <button type="button">Send</button>
        </div>

        <div class="meow-facts-content">
            <?= $content ?>
        </div>
    </div>
</body>
</html>
