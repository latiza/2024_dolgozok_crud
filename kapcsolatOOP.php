<?php
// A Dotenv osztály importálása
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Adatbázis kapcsolat osztály
class DatabaseConnection {
    private $dbconn;

    // Konstruktor, amely inicializálja az adatbázis kapcsolatot
    public function __construct() {
        // .env fájl betöltése és környezeti változók beállítása
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Adatbázis kapcsolati adatok meghatározása környezeti változók használatával
        $dbhost = $_ENV['DBHOST'];
        $dbuser = $_ENV['DBUSER'];
        $dbpass = $_ENV['DBPASS'];
        $dbname = $_ENV['DBNAME'];

        // Adatbázis kapcsolat létrehozása
        $this->dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        // Ellenőrzi, hogy a kapcsolat létrejött-e
        if ($this->dbconn->connect_error) {
            // Hibaüzenet megjelenítése
            die("Hiba az adatbázis csatlakozásakor: " . $this->dbconn->connect_error);
        } else {
            echo "Kapcsi létrejött";
        }

        // Beállítja az adatbázis kapcsolat karakterkészletét UTF-8-ra
        if (!$this->dbconn->set_charset("utf8")) {
            // Hibaüzenet megjelenítése
            die("Hiba az adatbázis karakterkészletének beállításakor: " . $this->dbconn->error);
        }
    }

    // Metódus, amely visszaadja az adatbázis kapcsolatot
    public function getConnection() {
        return $this->dbconn;
    }
}

// Adatbázis kapcsolat létrehozása
$dbConnection = new DatabaseConnection();
$dbconn = $dbConnection->getConnection();

