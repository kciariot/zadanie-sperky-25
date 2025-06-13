function loadNewMeowFacts() {
    let form = document.querySelector('.form-container');

    let params = new URLSearchParams({
        request: 'loadNewMeowFacts',
        id: form.querySelector('input[name="id"]').value,
        count: form.querySelector('input[name="count"]').value,
        lang: form.querySelector('select[name="lang"]').value,
        "no-validation": form.querySelector('input[name="no-validation"]').checked ? 1 : 0
    });

    fetch(`index.php?${params}`, {method: 'GET'})
        .then(response => response.json())
        .then(response => {
            if (typeof response.data === 'undefined') {
                if (typeof response.error !== 'undefined') {
                    throw new Error(response.error);
                } else {
                    throw new Error('Undefined error');
                }
            }

            updateMeowFactsDom(response.data);
        })
        .catch(error => {
            displayError(error);
        })
}

function updateMeowFactsDom(meowfacts) {
    let content = '';

    meowfacts.forEach(function (fact, index) {
        content += `<div class="meow-fact">${fact}</div>`;
    });

    document.querySelector('.meow-facts-content').innerHTML = content;
}

function displayError(error) {
    document.querySelector('.meow-facts-content').innerHTML = `<div class='error'>${error}</div>`;
}