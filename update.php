<?php
// echo $_GET['Id'];
// Voeg de verbindingsgegevens toe in config.php
require('config.php');

// Maak de data sourcename string
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

try {
    $pdo =  new PDO($dsn, $dbUser, $dbPass);
    if ($pdo) {
        // echo "Er is een verbinding met de database";
    } else {
        echo "Interne server-error";
    }
} catch(PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // var_dump($_POST);
    // Maak een sql update-query en vuur deze af op de database

    try {
        $sql = "UPDATE afsrpaak
            SET    kleuren = :color,
                   telnr = :phone,
                   email = :mail,
                   afspraak = :afspr,
                   behandeling = :treatments,
                   datuminvoer = :datesubmit
            WHERE  afsrpaak = :afspr";

    $statement = $pdo->prepare($sql);

    $statement->bindValue(':color', $_POST['colors'], PDO::PARAM_STR);
    $statement->bindValue(':phone', $_POST['phonenr'], PDO::PARAM_STR);
    $statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
    $statement->bindValue(':afspr', $_POST['date'], PDO::PARAM_STR);
    $statement->bindValue(':treatments', $_POST['treatment'], PDO::PARAM_STR);
    $statement->bindValue(':datesubmit', $_POST['dateSubmit'], PDO::PARAM_STR);
    

    $statement->execute();

    echo "Het updaten is gelukt";
    header('Refresh:1; url=read.php');
    } catch(PDOException $e) {
        echo "Het updaten is niet gelukt";
        header('Refresh:1; url=read.php');
    }
    

    // Stuur de gebruiker door naar de read.php pagina voor het overzicht met een header(Refresh) functie;
    exit();
}

// Maak een sql-query voor de database
$sql = "SELECT kleuren
                ,telnr
                ,email
                ,afspraak
                ,behandeling
                ,datuminvoer
        FROM afspraak
        WHERE afspraak = :afspr";

// Maak de sql-query klaar om de $_GET['Id'] waarde te koppelen aan de placeholder :Id
$statement = $pdo->prepare($sql);

// Koppel de waarde $_GET['Id'] aan de placeholder :Id
$statement->bindValue(':afspr', $_GET['date'], PDO::PARAM_INT);

// Voer de query uit
$statement->execute();

// Haal het resultaat op met fetch en stop het object in de variabele $result
$result = $statement->fetch(PDO::FETCH_OBJ);

// var_dump($result);





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>PHP PDO CRUD</title>
</head>
<body>
    <h1>PHP PDO CRUD</h1>
    
    <form action="update.php" method="post">

        <label for="firstname">Voornaam:</label><br>
        <input type="text" name="firstname" id="firstname" value="<?= $result->Voornaam; ?>"><br>
        <br>
        <label for="infix">Tussenvoegsel:</label><br>
        <input type="text" name="infix" id="infix" value="<?= $result->Tussenvoegsel; ?>"><br>
        <br>
        <label for="lastname">Achternaam:</label><br>
        <input type="text" name="lastname" id="lastname" value="<?= $result->Achternaam; ?>"><br>
        <br>
        <label for="haircolor">Haarkleur:</label><br>
        <input type="text" name="haircolor" id="haircolor" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <label for="phonenumber">Telefoonnummer:</label><br>
        <input type="number" name="phonenumber" id="phonenumber" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <label for="streetname">Straatnaam:</label><br>
        <input type="text" name="streetname" id="streetname" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <label for="housenumber">Huisnummer:</label><br>
        <input type="number" name="housenumber" id="housenumber" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <label for="city">Woonplaats:</label><br>
        <input type="text" name="city" id="city" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <label for="postalcode">Postcode:</label><br>
        <input type="text" name="postalcode" id="postalcode" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <label for="country">Landnaam:</label><br>
        <input type="text" name="country" id="country" value="<?= $result->Haarkleur; ?>"><br>
        <br>
        <input type="hidden" name="id" value="<?= $result->Id; ?>">
        <br>


        <input type="submit" value="Sla Op">        

    </form>
</body>
</html>