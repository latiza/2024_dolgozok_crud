<?php
// Kapcsolat.php fájl betöltése, ahol az adatbázis kapcsolati adatok találhatók
require_once 'kapcsolat.php';

// Ellenőrizze, hogy a kérési módszer GET-e
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Válassza ki az összes sort a 'csokik' táblából
        $sql = "SELECT * FROM dolgozok";
        $result = mysqli_query($dbconn, $sql);

        if (!$result) {
            // Kezelje a lekérdezési hibát
            http_response_code(500); // Belső szerverhiba
            die("Hiba a kiválasztásnál: " . mysqli_error($dbconn));
        }

        // Fetch minden sort asszociatív tömbként
        $dolgozok = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $dolgozok[] = $row;
        }

        // Zárja le az adatbázis kapcsolatot
        mysqli_close($dbconn);

        // Küldje el a szebben formázott JSON választ
        header('Content-Type: application/json;charset=utf-8');
        echo json_encode($dolgozok, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Menti a dolgozokat a dolgozok.json fájlba
        //file_put_contents('dolgozok.json', json_encode($dolgozok, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    } catch (Exception $e) {
        // Kezelje a többi kivételt
        http_response_code(500); // Belső szerverhiba
        echo "Hiba: " . $e->getMessage();
        /**A catch (Exception $e) { } blokk egy olyan szerkezet a PHP-ban, amely lehetővé teszi a kivételek kezelését.

A kivételek olyan hibák vagy rendellenességek, amelyek megakadályozzák a program folyamatának normális lefutását. Például ha valamilyen hiba történik egy adatbázis lekérdezés során, vagy ha egy fájl nem található meg.

A try { } blokkban található kódot próbálja meg végrehajtani a PHP. Ha bármilyen hiba vagy kivétel merül fel a try blokkban, akkor a vezérlés átkerül a catch (Exception $e) { } blokkba.

A $e változó az a kivétel objektum, amely tartalmazza a hibával kapcsolatos információkat, például a hibaüzenetet vagy a hiba kódját. A catch blokkban meg lehet adni különféle műveleteket vagy kezeléseket, amelyek a kivétel kezelését szolgálják, például hibaüzenet kiírása vagy naplózása, vagy további műveletek végrehajtása a hiba körülményeinek függvényében.

Ez a mechanizmus lehetővé teszi a program számára, hogy kezelje a váratlan helyzeteket vagy hibákat, és elegánsan reagáljon rájuk anélkül, hogy megakadna vagy leállna. */
    }
} else {
    // Kezelje az érvénytelen kérési módszert
    http_response_code(405); // Nem megengedett kérési módszer
}

