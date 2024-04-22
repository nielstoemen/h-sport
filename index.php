<?php
$api_key = 'HuzBrQx4MRx9LEHMIZTedDKobmHYQHzR2HlMyBlH';
?>

<!-- HTML-formulier met zoekbalk -->
<form method="GET" action="" id="searchForm">
    <label for="search_term">Zoekterm:</label>
    <input type="text" id="search_term" name="search_term" required>
    <button type="submit">Zoeken</button>
</form>

<!-- Container voor realtime resultaten -->
<div id="searchResults"></div>

<!-- JavaScript voor realtime bijwerken van resultaten -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('searchForm');
    var searchResults = document.getElementById('searchResults');
    var api_key = '<?php echo $api_key; ?>';

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        // Voer zoekactie uit bij formulierinzending
        performSearch();
    });

    var debounceTimer;
    var searchInput = document.getElementById('search_term');
    searchInput.addEventListener('input', function () {
        // Gebruik debouncing om het aantal API-aanroepen te verminderen
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(performSearch, 500);
    });

    function performSearch() {
        var searchTerm = searchInput.value.trim();
        if (searchTerm.length === 0) {
            // Geen zoekterm, toon alle voedsels op alfabetische volgorde
            displayAllFoods();
        } else {
            // Voer de API-aanroep uit met behulp van JavaScript Fetch API
            fetch('https://api.nal.usda.gov/fdc/v1/foods/search?query=' + searchTerm + '&api_key=' + api_key)
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    // Verwerk de resultaten en toon ze
                    displayResults(data);
                })
                .catch(function (error) {
                    console.error('Fout bij het ophalen van gegevens van de USDA API', error);
                });
        }
    }

    function displayResults(data) {
        if (data.foods && data.foods.length > 0) {
            // Bouw de HTML voor de resultaten
            var html = '<ul>';
            data.foods.forEach(function (food) {
                html += '<li><strong>Description:</strong> ' + (food.description ? food.description : 'Geen beschikbare beschrijving') + '<br>';
                html += '<strong>Food Nutrients:</strong><ul>';
                if (food.foodNutrients && food.foodNutrients.length > 0) {
                    food.foodNutrients.forEach(function (nutrient) {
                        html += '<li>' + nutrient.nutrientName + ': ' + nutrient.value + ' ' + nutrient.unitName + '</li>';
                    });
                } else {
                    html += '<li>Geen beschikbare voedingsstoffen</li>';
                }
                html += '</ul></li><hr>';
            });
            html += '</ul>';

            // Toon de resultaten
            searchResults.innerHTML = html;
        } else {
            // Geen resultaten gevonden
            searchResults.innerHTML = 'Geen resultaten gevonden voor de zoekterm: ' + searchInput.value;
        }
    }

    function displayAllFoods() {
        // Voer de API-aanroep uit om alle voedsels op alfabetische volgorde op te halen
        fetch('https://api.nal.usda.gov/fdc/v1/foods?api_key=' + api_key)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                // Sorteer de voedselgegevens op alfabetische volgorde
                var sortedFoods = data.foods.sort(function (a, b) {
                    return a.description.localeCompare(b.description);
                });

                // Bouw de HTML voor de resultaten
                var html = '<ul>';
                sortedFoods.forEach(function (food) {
                    html += '<li><strong>Description:</strong> ' + (food.description ? food.description : 'Geen beschikbare beschrijving') + '<br>';
                    html += '<strong>Food Nutrients:</strong><ul>';
                    if (food.foodNutrients && food.foodNutrients.length > 0) {
                        food.foodNutrients.forEach(function (nutrient) {
                            html += '<li>' + nutrient.nutrientName + ': ' + nutrient.value + ' ' + nutrient.unitName + '</li>';
                        });
                    } else {
                        html += '<li>Geen beschikbare voedingsstoffen</li>';
                    }
                    html += '</ul></li><hr>';
                });
                html += '</ul>';

                // Toon de resultaten
                searchResults.innerHTML = html;
            })
            .catch(function (error) {
                console.error('Fout bij het ophalen van gegevens van de USDA API', error);
            });
    }
});
</script>
