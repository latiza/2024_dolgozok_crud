
<?php
// Ha nincs 'id' paraméter az URL-ben, átirányít a lista.php oldalra
if (!isset($_REQUEST['id'])) {
    header("Location: lista.php");
    exit(); // Megszakítjuk a további kód végrehajtását
}

require("kapcsolat.php");

// Űrlap feldolgozása
if (isset($_POST['rendben'])) {
    // Változók tisztítása és validáció
    $nev    = trim(ucwords(strtolower($_POST['nev'])));
    $mobil  = trim($_POST['mobil']);
    $email  = trim($_POST['email']);

    // Hibaüzenetek tömbje
    $hibak = [];

    // Név ellenőrzése
    if (empty($nev)) {
        $hibak[] = "Nem adtál meg nevet!";
    } elseif (strlen($nev) < 5) {
        $hibak[] = "A névnek legalább 5 karakter hosszúnak kell lennie!";
    }

    // Mobilszám ellenőrzése
    if (!empty($mobil) && strlen($mobil) < 9) {
        $hibak[] = "A mobil számnak legalább 9 karakter hosszúnak kell lennie!";
    }

    // Email ellenőrzése
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hibak[] = "Rossz e-mail címet adtál meg!";
    }

    // Ha van hiba, összeállítjuk a hibaüzenetet
    if (!empty($hibak)) {
        $kimenet = "<ul>\n";
        foreach ($hibak as $hiba) {
            $kimenet .= "<li>{$hiba}</li>\n";
        }
        $kimenet .= "</ul>\n";
    } else {
        // Módosítás az adatbázisban
        $id = (int)$_POST['id'];
        $sql = "UPDATE dolgozok
                SET nev = '{$nev}', mobil = '{$mobil}', email = '{$email}'
                WHERE id = {$id}";
        mysqli_query($dbconn, $sql);

        // Sikeres módosítás esetén átirányítás a lista.php oldalra
        header("Location: lista.php");
        exit(); // Megszakítjuk a további kód végrehajtását
    }
}

// Űrlap előzetes kitöltése
$id = (int)$_GET['id'];
$sql = "SELECT *
        FROM dolgozok
        WHERE id = {$id}";
$eredmeny = mysqli_query($dbconn, $sql);
$sor = mysqli_fetch_assoc($eredmeny);

$nev    = $sor['nev'];
$mobil  = $sor['mobil'];
$email  = $sor['email'];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dolgozók szerkesztése</title>
<link href="stilus.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <h1>Dolgozók szerkesztése</h1>
    <form method="post" action="">
        <?php if (isset($kimenet)) print $kimenet; ?>

        <input type="hidden" id="id" name="id" value="<?php print $id; ?>">

        <p><label for="nev">Név*:</label><br>
        <input type="text" id="nev" name="nev" value="<?php print $nev; ?>"></p>

        <p><label for="mobil">Mobil:</label><br>
        <input type="tel" id="mobil" name="mobil" value="<?php print $mobil; ?>"></p>

        <p><label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" value="<?php print $email; ?>"></p>
        
        <p><em>A *-gal jelölt mezők kitöltése kötelező!</em></p>
        <input type="submit" id="rendben" name="rendben" value="Rendben">
        <input type="reset" value="Mégse">
        <p><a href="lista.php">Vissza a névjegyekhez</a></p>
    </form>
</div>
</body>
</html>
