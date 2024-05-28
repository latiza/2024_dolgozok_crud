
<?php
/*header("Content-Type:text/html; charset=utf-8");

define("DBHOST","localhost");
define("DBUSER","root");
define("DBPASS","");
define("DBNAME","dolgozok");

$dbconn = @mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die("Hiba az adatbázis csatlakozásakor!");

mysqli_query($dbconn, "SET NAMES utf8");*/

/*--------------------------------------------------------------*/

/**A .env fájl egy konfig fájl, környezeti változókat definiálhatunk benne. Ezeket az appunk futás közben olvassa be, és használja beállításokhoz, pl adatbázis kapcsolathoz, API kulcsokhoz, stb. A .env fájl azért hasznos, mert az érzékeny adatokat nem közvetlenül a forráskódban tároljuk, hanem külön fájlban, ami biztonságosabb. */

// .env fájl betöltése a Dotenv könyvtár segítségével
require 'vendor/autoload.php';
//telepíteni : composer require vlucas/phpdotenv

/* Létrehoz egy Dotenv objektumot, amely a megadott könyvtárban (általában a projekt gyökérkönyvtárában) keresi a .env fájlt.
Dotenv\Dotenv: Ez a Dotenv osztály teljes névtere és neve. A névtér (Dotenv) segít elkerülni az ütközéseket más osztályokkal.
::createImmutable(DIR): A :: operátor használatával hívjuk a createImmutable statikus metódust a Dotenv osztályban. Ez a metódus egy új Dotenv objektumot hoz létre, amely az aktuális könyvtárban (__DIR__) keresi a .env fájlt.
A :: operátor a PHP-ben az osztályok statikus tagjainak (metódusok, tulajdonságok, konstansok) elérésére szolgál. Ez lehetővé teszi a kód számára, hogy statikus kontextusban működjön, anélkül, hogy szükség lenne az osztály példányosítására.*/
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
//betölti a .env fájl tartalmát és beállítja a környezeti változókat, így azok elérhetők lesznek az alkalmazásban.
$dotenv->load();

// Beállítjuk a tartalom típusát és karakterkódolását
header("Content-Type: text/html; charset=utf-8");

// Az adatbázis kapcsolati adatok meghatározása környezeti változók használatával.
define("DBHOST", $_ENV['DBHOST']);
define("DBUSER", $_ENV['DBUSER']);
define("DBPASS", $_ENV['DBPASS']);
define("DBNAME", $_ENV['DBNAME']);

// Létrehozza az adatbázis kapcsolatot a mysqli objektum segítségével.
$dbconn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

// Ellenőrzi, hogy a kapcsolat létrejött-e, és ha nem, akkor hibaüzenetet logol és kilép.
if ($dbconn->connect_error) {
    // A hiba részleteinek logolása a szerver naplójába.
    error_log("Database connection failed: " . $dbconn->connect_error);
    // Hibaüzenet megjelenítése a felhasználó számára.
    die("Hiba az adatbázis csatlakozásakor!");
}else{
    echo "Kapcsi létrejött";
}

// Beállítja az adatbázis kapcsolat karakterkészletét UTF-8-ra.
// Ha a beállítás nem sikerül, akkor hibaüzenetet logol és kilép.
if (!$dbconn->set_charset("utf8")) {
    // A karakterkészlet beállításának hibájának logolása.
    error_log("Error loading character set utf8: " . $dbconn->error);
    // Hibaüzenet megjelenítése a felhasználó számára.
    die("Hiba az adatbázis karakterkészletének beállításakor!");
}



