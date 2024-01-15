<?php
// Functie om API-gegevens op te halen
function getApiData($apiKey) {
    // Implementeer de logica om gegevens van de USDA FoodData Central API op te halen
    // ...

    // Voorbeeld: hier wordt aangenomen dat de API een array met gegevens teruggeeft
    $apiUrl = "https://api.nal.usda.gov/fdc/v1/foods/list?api_key=$apiKey";
    $apiData = json_decode(file_get_contents($apiUrl), true);

    return $apiData;
}

// API-gegevens ophalen
$apiKey = "HuzBrQx4MRx9LEHMIZTedDKobmHYQHzR2HlMyBlH";
$apiData = getApiData($apiKey);

// Gebruik de $apiData voor verdere verwerking
// print_r($apiData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>h+sport</title>
</head>
<body>
<?php foreach ($apiData as $index => $result): ?>
            <label>
                <input type="radio" name="selected_result" value="<?php echo $index; ?>">
                <?php echo isset($result['description']) ? $result['description'] : 'Geen description beschikbaar'; ?>
            </label><br>
        <?php endforeach; ?>
</body>
</html>
