function getNewMeowFacts(button) {
    // Prevent spamming request
    button.setAttribute('disabled', true);

    let form = document.querySelector('.form-container');

    let params = {
        request: 'getNewMeowFacts',
    };

    // Minimize data sent in request
    if (form.querySelector('input[name="id"]').value !== '') {
        params.id = form.querySelector('input[name="id"]').value;
    }

    if (form.querySelector('input[name="count"]').value !== '') {
        params.count = form.querySelector('input[name="count"]').value;
    }

    if (form.querySelector('select[name="lang"]').value !== '') {
        params.lang = form.querySelector('select[name="lang"]').value;
    }

    // Parse object into GET parameters
    params = new URLSearchParams(params);

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
            button.removeAttribute('disabled');
        })
        .catch(error => {
            displayError(error);
            button.removeAttribute('disabled');
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

function validateMinNumber(element) {
    let minimalValue = element.getAttribute('min');
    let value = element.value;

    if (typeof minimalValue === 'undefined' || minimalValue === '') {
        return;
    }

    if (value === '') {
        return;
    }

    if (value < minimalValue) {
        element.value = minimalValue;
    }
}