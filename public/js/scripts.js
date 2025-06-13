function loadNewMeowFacts()
{
    let form  = document.querySelector('.form-container');

    let params = new URLSearchParams({
        request: 'loadNewMeowFacts',
        id: form.querySelector('input[name="id"]').value,
        count: form.querySelector('input[name="count"]').value,
        lang: form.querySelector('select[name="lang"]').value
    });


    fetch(`index.php?${params}`, {method: 'GET'})
        .then(response => response.json())
        .then(data => {
            updateMeowFactsDom(data.data);
        })
        .catch(error => console.log(error))
}

function updateMeowFactsDom(meowfacts)
{
    let content = '';

    meowfacts.forEach(function (fact, index) {
        content += `<div class="meow-fact">${fact}</div>`;
    });

    document.querySelector('.meow-facts-content').innerHTML = content;
}