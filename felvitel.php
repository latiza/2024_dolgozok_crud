<<<<<<< HEAD
<?php

// Űrlap feldolgozása
if (isset($_POST['rendben'])) {

	// Változók tisztítása
/**A strip_tags helyett a htmlspecialchars függvényt használjuk, hogy a felhasználói bemenetet biztonságosabbá tegyük, és kiküszöböljük a lehetséges XSS támadásokat.
A strtolower függvénnyel a mobiltelefonszámok és az e-mail címek kisbetűsítését végezzük el, ami megkönnyíti az azonosítást és egyértelműsíti az adatokat.
A ucwords függvénnyel a nevet alakítjuk nagybetűssé, így biztosítva, hogy az adatok megfelelő formátumban legyenek.
A trim függvénnyel eltávolítjuk az adatok körül lévő felesleges szóközöket.
Az htmlspecialcharacters függvény meggátolja, hogy a felhasználók be tudjanak küldeni rosszindulatú szkripteket, mivel azokat átalakítja megfelelő HTML entitásokká. */
	$nev    = htmlspecialchars(trim(ucwords(strtolower($_POST['nev']))));
	$mobil  = htmlspecialchars(trim($_POST['mobil']));
	$email  = strtolower(htmlspecialchars(trim($_POST['email'])));

	// Változók vizsgálata
	if (empty($nev))
		$hibak[] = "Nem adott meg nevet!";
	elseif (strlen($nev) < 5)
		$hibak[] = "Rossz nevet adott meg!";
	
	if (!empty($mobil) && strlen($mobil) < 9)
		$hibak[] = "Rossz mobil számot adott meg!";
	if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL))
		$hibak[] = "Rossz e-mail címet adott meg!";

	// Hibaüzenetet összeállítása
	if (isset($hibak)) {
		$kimenet = "<ul>\n";
		foreach($hibak as $hiba) {
			$kimenet.= "<li>{$hiba}</li>\n";
		}
		$kimenet.= "</ul>\n";
	}
	else {
		// Felvitel az adatbázisba
		require("kapcsolat.php");
		$sql = "INSERT INTO dolgozok
				(nev,  mobil, email)
				VALUES
				('{$nev}', '{$mobil}', '{$email}')";
		mysqli_query($dbconn, $sql);
		header("Location: lista.php");
	}
}

// Űrlap megjelenítése
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dolgozók</title>
<link href="stilus.css" rel="stylesheet">
</head>

<body>
	<div class="container">
	
<h1>Új dolgozó felvitele</h1>
<form method="post" action="">
	<?php if (isset($kimenet)) print $kimenet; ?>
	
	<p><label for="nev">Név*:</label><br>
	<input type="text" id="nev" name="nev" value="<?php if (isset($nev)) print $nev; ?>"></p>
	
	<p><label for="mobil">Mobil:</label><br>
	<input type="tel" id="mobil" name="mobil" value="<?php if (isset($mobil)) print $mobil; ?>"></p>

	<p><label for="email">E-mail:</label><br>
	<input type="email" id="email" name="email" value="<?php if (isset($email)) print $email; ?>"></p>

	<p><em>A *-gal jelölt mezők kitöltése kötelező!</em></p>
	<input type="submit" id="rendben" name="rendben" value="Rendben">
	<p><a href="lista.php">Vissza a listához</a></p>

	</div>
</form>
</body>
</html>
=======
<?php

// Űrlap feldolgozása
if (isset($_POST['rendben'])) {

	// Változók tisztítása
/**A strip_tags helyett a htmlspecialchars függvényt használjuk, hogy a felhasználói bemenetet biztonságosabbá tegyük, és kiküszöböljük a lehetséges XSS támadásokat.
A strtolower függvénnyel a mobiltelefonszámok és az e-mail címek kisbetűsítését végezzük el, ami megkönnyíti az azonosítást és egyértelműsíti az adatokat.
A ucwords függvénnyel a nevet alakítjuk nagybetűssé, így biztosítva, hogy az adatok megfelelő formátumban legyenek.
A trim függvénnyel eltávolítjuk az adatok körül lévő felesleges szóközöket.
Az htmlspecialcharacters függvény meggátolja, hogy a felhasználók be tudjanak küldeni rosszindulatú szkripteket, mivel azokat átalakítja megfelelő HTML entitásokká. */
	$nev    = htmlspecialchars(trim(ucwords(strtolower($_POST['nev']))));
	$mobil  = htmlspecialchars(trim($_POST['mobil']));
	$email  = strtolower(htmlspecialchars(trim($_POST['email'])));

	// Változók vizsgálata
	if (empty($nev))
		$hibak[] = "Nem adott meg nevet!";
	elseif (strlen($nev) < 5)
		$hibak[] = "Rossz nevet adott meg!";
	
	if (!empty($mobil) && strlen($mobil) < 9)
		$hibak[] = "Rossz mobil számot adott meg!";
	if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL))
		$hibak[] = "Rossz e-mail címet adott meg!";

	// Hibaüzenetet összeállítása
	if (isset($hibak)) {
		$kimenet = "<ul>\n";
		foreach($hibak as $hiba) {
			$kimenet.= "<li>{$hiba}</li>\n";
		}
		$kimenet.= "</ul>\n";
	}
	else {
		// Felvitel az adatbázisba
		require("kapcsolat.php");
		$sql = "INSERT INTO dolgozok
				(nev,  mobil, email)
				VALUES
				('{$nev}', '{$mobil}', '{$email}')";
		mysqli_query($dbconn, $sql);
		header("Location: lista.php");
	}
}

// Űrlap megjelenítése
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Dolgozók</title>
<link href="stilus.css" rel="stylesheet">
</head>

<body>
	<div class="container">
	
<h1>Új dolgozó felvitele</h1>
<form method="post" action="">
	<?php if (isset($kimenet)) print $kimenet; ?>
	
	<p><label for="nev">Név*:</label><br>
	<input type="text" id="nev" name="nev" value="<?php if (isset($nev)) print $nev; ?>"></p>
	
	<p><label for="mobil">Mobil:</label><br>
	<input type="tel" id="mobil" name="mobil" value="<?php if (isset($mobil)) print $mobil; ?>"></p>

	<p><label for="email">E-mail:</label><br>
	<input type="email" id="email" name="email" value="<?php if (isset($email)) print $email; ?>"></p>

	<p><em>A *-gal jelölt mezők kitöltése kötelező!</em></p>
	<input type="submit" id="rendben" name="rendben" value="Rendben">
	<p><a href="lista.php">Vissza a listához</a></p>

	</div>
</form>
</body>
</html>
>>>>>>> 60f028107d7dea39677ca46f4cc3b99ab262c2dc
