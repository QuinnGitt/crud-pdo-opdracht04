<?php
require('config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);

    if ($pdo) {
    } else {
        echo "Er is een interne server-error, neem contact op met de beheerder";
    }

} catch(PDOException $e) {
    echo $e->getMessage();
}
$sql = "INSERT INTO Afspraak (kleuren
                            ,telnr
                            ,email
                            ,afspraak
                            ,behandeling
                            ,datuminvoer)
        VALUES              (:color
                            ,:phone
                            ,:mail
                            ,:afspr
                            ,:treatments
                            ,:datesubmit);";

$statement = $pdo->prepare($sql);
$colors = implode(",", $_POST['colors']);
$treatment = implode("," ,$_POST['treatment'] );

$statement->bindValue(':color', $colors, PDO::PARAM_STR);
$statement->bindValue(':phone', $_POST['phonenr'], PDO::PARAM_STR);
$statement->bindValue(':mail', $_POST['mail'], PDO::PARAM_STR);
$statement->bindValue(':afspr', $_POST['date'], PDO::PARAM_STR);
$statement->bindValue(':treatments',$treatment , PDO::PARAM_STR);
$statement->bindValue(':datesubmit', $_POST['dateSubmit'], PDO::PARAM_STR);

$result = $statement->execute();

if ($result) {
    echo "Er is een nieuw record gemaakt in de database.";
    header('Refresh:2; url=read.php');
} else {
    echo "Er is geen nieuw record gemaakt.";
    header('Refresh:2; url=read.php');
}
 