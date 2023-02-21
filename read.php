<?php
  require('config.php');
  $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

  try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    if ($pdo) {
    } else {
        echo "Interne server-error";
    }
  } catch(PDOException $e) {
    echo $e->getMessage();
  }
  $sql = "SELECT kleuren
                ,telnr
                ,email
                ,afspraak
                ,behandeling
                ,datuminvoer
          FROM afspraak";



  $statement = $pdo->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_OBJ);

  $rows = "";
  foreach ($result as $info) {
    $rows .= "<tr>
                <td>$info->kleuren</td>
                <td>$info->telnr</td>
                <td>$info->email</td>
                <td>$info->afspraak</td>
                <td>$info->behandeling</td>
                <td>$info->datuminvoer</td>
                <td>
                    <a href='delete.php?Id=$info->afspraak'>
                        <img src='img/b_drop.png' alt='kruis'>
                    </a>
                </td>
                <td>
                    <a href='update.php?Id=$info->afspraak'>
                        <img src='img/b_edit.png' alt='potlood'>
                    </a>
                </td>
              </tr>";
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Afspraakgegevens</h3>

    <a href="index.php">
        <input type="button" value="Nieuw record">
    </a>
    <br>
    <br>
    <table border='1'>
        <thead>
            <th>kleuren</th>
            <th>telnr</th>
            <th>email</th>
            <th>afspraak</th>
            <th>behandeling</th>
            <th>datuminvoer</th>
        </thead>
        <tbody>
            <?= $rows; ?>
        </tbody>
    </table>
</body>
</html>

