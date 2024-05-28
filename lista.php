
<?php

require("kapcsolat.php");
/**A mysqli_real_escape_string() funkció a kapott bemeneti karakterláncot úgy formázza, hogy a speciális karaktereket úgy helyettesíti, hogy azok ne legyenek értelmezve az SQL lekérdezés részeként. Például a felhasználó által bevitt idézőjelek (') az adatbázisban használhatatlanná válnak a kódolás után. */
$kifejezes = isset($_POST['kifejezes']) ? mysqli_real_escape_string($dbconn, $_POST['kifejezes']) : "";
$sql = "SELECT *
		FROM dolgozok
		WHERE (
			nev LIKE '%{$kifejezes}%'
			OR mobil LIKE '%{$kifejezes}%'
			OR email LIKE '%{$kifejezes}%'
		)";
/**Az SQL lekérdezésekben a % karakter egy ún. "wildcard" karakter, amely azt jelenti, hogy bármely karakterláncot helyettesíthet. Ha a LIKE operátorral együtt használjuk, akkor azt jelzi, hogy a megadott mintázat előtt és/vagy után bármi állhat.
Tehát a nev LIKE '%{$kifejezes}%' kifejezés azt jelenti, hogy az adatbázis keresni fog minden olyan rekordot, amelynek a "nev" mezője tartalmazza a $kifejezes változóban tárolt karakterláncot. A % karakterek azt jelzik, hogy a $kifejezes változó előtt és után bármilyen karakterlánc szerepelhet. Ez egyfajta szabadon formázott keresést tesz lehetővé, amely nem kötődik a karakterlánc pontos helyéhez a mezőben. */
$eredmeny = mysqli_query($dbconn, $sql);

$kimenet = "<table>
<tr>
	<th>Név</th>
	<th>Mobil</th>
	<th>E-mail</th>
	<th>Művelet</th>
</tr>";
/**A mysqli_fetch_assoc() függvény egyetlen sort kér le az adatbázis eredményhalmazából, és azt egy asszociatív tömbként adja vissza, ahol az oszlopnevek a tömb kulcsai, és az oszlopokban tárolt értékek a tömb értékei. */
while ($sor = mysqli_fetch_assoc($eredmeny)) {
	$kimenet.= "<tr>
		<td>{$sor['nev']}</td>
		<td>{$sor['mobil']}</td>
		<td>{$sor['email']}</td>
		<td><a href=\"torles.php?id={$sor['id']}\">Törlés</a> | <a href=\"modositas.php?id={$sor['id']}\">Módosítás</a></td>
	</tr>";
}
$kimenet.= "</table>";
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
	<input type="search" id="kifejezes" name="kifejezes">
</form>
<p><a href="felvitel.php">Új névjegy</a></p>
<?php print $kimenet; ?>

</div>
</body>
</html>
