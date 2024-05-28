<?php
// DolgozoApi osztály definíciója
class DolgozoApi {
    private $dbconn; // Az adatbázis kapcsolatot tároló privát változó

    // Konstruktor, amely inicializálja az adatbázis kapcsolatot
    public function __construct($dbconn) {
        $this->dbconn = $dbconn; // Az adatbázis kapcsolatot beállítjuk a kapott értékre
    }

    // Metódus, amely lekéri és visszaadja a dolgozók adatait JSON formátumban
    public function getDolgozok() {
        try {
            // Lekérdezés futtatása az adatbázison
            $sql = "SELECT * FROM dolgozok";
            $result = mysqli_query($this->dbconn, $sql);

            if (!$result) {
                // Hiba kezelése, ha a lekérdezés nem sikerült
                http_response_code(500); // Belső szerverhiba
                die("Hiba a kiválasztásnál: " . mysqli_error($this->dbconn));
            }

            // Fetch minden sort asszociatív tömbként
            $dolgozok = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $dolgozok[] = $row; // Minden sor hozzáadása a $dolgozok tömbhöz
            }

            // Adatbázis kapcsolat lezárása
            mysqli_close($this->dbconn);

            // JSON válasz küldése a kliensnek
            header('Content-Type: application/json;charset=utf-8');
            echo json_encode($dolgozok, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            // Kivétel kezelése, ha bármilyen hiba történik a folyamat során
            http_response_code(500); // Belső szerverhiba
            echo "Hiba: " . $e->getMessage();
        }
    }
}

// Kapcsolat.php fájl betöltése, ahol az adatbázis kapcsolati adatok találhatók
require_once 'kapcsolatOOP.php';

// Ellenőrizzük, hogy a kérési módszer GET-e
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Létrehozzuk a DolgozoApi objektumot, amely inicializálja az adatbázis kapcsolatot
    $api = new DolgozoApi($dbconn);
    // Hívjuk meg a getDolgozok metódust, ami visszaadja a dolgozók adatait JSON formátumban
    $api->getDolgozok();
} else {
    // Kezeljük az érvénytelen kérési módszert
    http_response_code(405); // Nem megengedett kérési módszer
}

