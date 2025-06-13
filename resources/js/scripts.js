function loadNewMeowFacts(button) {
    if (button.classList.contains('disabled')) {
        return;
    }

    button.classList.add('disabled');

    let form = document.querySelector('.form-container');

    let params = {
        request: 'loadNewMeowFacts',
    };

    if (form.querySelector('input[name="id"]').value !== '') {
        params.id = form.querySelector('input[name="id"]').value;
    }

    if (form.querySelector('input[name="count"]').value !== '') {
        params.count = form.querySelector('input[name="count"]').value;
    }

    if (form.querySelector('select[name="lang"]').value !== '') {
        params.lang = form.querySelector('select[name="lang"]').value;
    }

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
            button.classList.remove('disabled');
        })
        .catch(error => {
            displayError(error);
            button.classList.remove('disabled');
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