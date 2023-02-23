<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Bling Bling Nagelstudio Chantal</h1>
    <form action="create.php" method="post">
        <label for="colors">Kies 4 basiskleuren voor uw nagels:</label>
        <br>
        <input type="color" name="colors[]" id="colors1">
        <input type="color" name="colors[]" id="colors2">
        <input type="color" name="colors[]" id="colors3">
        <input type="color" name="colors[]" id="colors4">
        <br>
        <br>
        <label for="phonenr">Uw telefoon nummer:</label><br>
        <input type="tel" name="phonenr" id="phonenr">
        <br>
        <br>
        <label for="mail">Uw emailadres:</label><br>
        <input type="email" name="mail" id="mail">
        <br>
        <br>
        <label for="date">Afspraak datum:</label><br>
        <input type="datetime-local" name="date" id="date">

        <input type="hidden" value="<?= date('Y-m-d H:i:s');?>" name="dateSubmit">
        <br>
        <br>
        <label for="treatment">Soort behandeling:</label>
        <br>
        <input type="checkbox" name="treatment[]" id="treatment" value="">
        <label for="treatment">Nagelbijt arrangement (termijnbetaling mogelijk) €180
        </label><br>

        <input type="checkbox" name="treatment[]" id="treatment" value="Luxe manicure">
        <label for="treatment">Luxe manicure (massage en handpakking) €30,00</label><br>

        <input type="checkbox" name="treatment[]" id="treatment" value="Nagelreparatie">
        <label for="treatment">Nagelreparatie per nagel (in eerste week gratis) €5,00</label><br>

        <br>
        
        <input type="submit" value="Sla Op">
        <input type="reset" value="Reset">
    </form>
</body>
</html>