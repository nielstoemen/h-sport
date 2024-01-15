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

// Inloggen
if (isset($_POST['login'])) {
    // Voeg hier eventuele inloglogica toe (bijvoorbeeld validatie van gebruikersnaam en wachtwoord)
    // ...

    // Voor nu gaan we ervan uit dat de inloggegevens geldig zijn
    // Je kunt hier later gebruikersgegevens in een sessie opslaan als dat nodig is
    echo "Inloggen succesvol!";
}

// API-gegevens ophalen
$apiKey = "HuzBrQx4MRx9LEHMIZTedDKobmHYQHzR2HlMyBlH";
$apiData = getApiData($apiKey);

// Gebruik de $apiData voor verdere verwerking
print_r($apiData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimalistische Applicatie</title>
</head>
<body>
    <!-- Inlogformulier -->
    <form method="post" action="">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" name="username" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Inloggen</button>
    </form>
</body>
</html>
