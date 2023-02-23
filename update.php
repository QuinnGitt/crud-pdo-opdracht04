<?php
// echo $_GET['Id'];
// Voeg de verbindingsgegevens toe in config.php
require('config.php');

// Maak de data sourcename string
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    if ($pdo) {
        // echo "Er is een verbinding met de database";
    } else {
        echo "Interne server-error";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // var_dump($_POST);
    // Maak een sql update-query en vuur deze af op de database

    try {
        $sql = "UPDATE afspraak
            SET    kleuren = :color,
                   telnr = :phone,
                   email = :mail,
                   afspraak = :afspr,
                   behandeling = :treatments,
                   datuminvoer = :datesubmit
            WHERE  Id = :Id";

        $statement = $pdo->prepare($sql);

        $colors = implode(",", $_POST['colors']);
        $treatment = implode("," ,$_POST['treatment'] );

        $statement->bindValue(':color', $colors, PDO::PARAM_STR);
        $statement->bindValue(':phone', $_POST['phonenr'], PDO::PARAM_STR);
        $statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
        $statement->bindValue(':afspr', $_POST['date'], PDO::PARAM_STR);
        $statement->bindValue(':treatments',$treatment , PDO::PARAM_STR);
        $statement->bindValue(':datesubmit', $_POST['dateSubmit'], PDO::PARAM_STR);
        $statement->bindValue(':Id', $_POST['Id'], PDO::PARAM_STR);


        $statement->execute();

        echo "Het updaten is gelukt";
        header('Refresh:1; url=read.php');
    } catch (PDOException $e) {
        echo "Het updaten is niet gelukt";
        header('Refresh:1; url=read.php');
    }

    exit();
}

$sql = "SELECT  kleuren
                ,telnr
                ,email
                ,afspraak
                ,behandeling
                ,datuminvoer
        FROM afspraak
        WHERE Id = :Id";

// Maak de sql-query klaar om de $_GET['Id'] waarde te koppelen aan de placeholder :Id
$statement = $pdo->prepare($sql);

// Koppel de waarde $_GET['Id'] aan de placeholder :Id
$statement->bindValue(':Id', $_GET['Id'], PDO::PARAM_INT);

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
    <title>Afspraak update</title>
</head>

<body>
    <h1>Afspraak update</h1>

    <form action="update.php" method="post">
        <label for="colors">Kies 4 basiskleuren voor uw nagels:</label>
        <br>
        <?php
        $colors = explode(",", $result->kleuren);
        ?>
        <input type="color" name="colors[]" id="colors1" value="<?= $colors[0]; ?>">
        <input type="color" name="colors[]" id="colors2" value="<?= $colors[1]; ?>">
        <input type="color" name="colors[]" id="colors3" value="<?= $colors[2]; ?>">
        <input type="color" name="colors[]" id="colors4" value="<?= $colors[3]; ?>">
        <br>
        <br>
        <label for="phonenr">Uw telefoon nummer:</label><br>
        <input type="tel" name="phonenr" id="phonenr" value="<?= $result->telnr; ?>">
        <br>
        <br>
        <label for="mail">Uw emailadres:</label><br>
        <input type="email" name="mail" id="mail" value="<?= $result->email; ?>">
        <br>
        <br>
        <label for="date">Afspraak datum:</label><br>
        <input type="datetime-local" name="date" id="date" value="<?= $result->afspraak; ?>">

        <input type="hidden" value="<?= date('Y-m-d H:i:s'); ?>" name="dateSubmit" value="<?= $result->datuminvoer; ?>">
        <br>
        <br>
        <label for="treatment">Soort behandeling:</label>
        <br>
        <input type="checkbox" name="treatment" id="treatment" value="Nagelbijt arrangement">
        <label for="treatment">Nagelbijt arrangement (termijnbetaling mogelijk) €180
        </label><br>

        <input type="checkbox" name="treatment" id="treatment" value="Luxe manicure">
        <label for="treatment">Luxe manicure (massage en handpakking) €30,00</label><br>

        <input type="checkbox" name="treatment" id="treatment" value="Nagelbijt arrangement">
        <label for="treatment">Nagelreparatie per nagel (in eerste week gratis) €5,00</label><br>

        <br>

        <input type="submit" value="Sla Op">
        <input type="reset" value="Reset">
    </form>
</body>

</html>