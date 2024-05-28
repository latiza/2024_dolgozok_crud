<?php
//telepíteni: composer require --dev phpunit/phpunit

/**A declare(strict_types=1); egy PHP 7-ben bevezetett deklaráció, amely beállítja a szigorú típusellenőrzést az adott fájlban vagy blokkban. Amikor ezt a deklarációt használjuk, a PHP értékadásoknál és függvényhívásoknál is ellenőrzi a típusokat a deklarált típusok alapján, és hibát dob, ha nem megfelelő típust talál.

Például ha egy függvény paramétere típusként int-et vár, és mi string típusú változót adunk át neki, akkor a szigorú típusok beállításával a PHP hibát dob, mert a típus nem egyezik meg.

Ez segít a kód hibáinak korai felfedezésében és megakadályozza a hibás típusú értékek hibákat okozó futtatását. Ez különösen hasznos lehet nagyobb projektekben vagy csapatmunka során, ahol fontos a kód minősége és megbízhatósága. */
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// Tesztelendő osztály beolvasása
require_once 'kapcsolat.php';
/**A PHPUnit egy népszerű PHP tesztelési keretrendszer, amelyet leginkább egységtesztek írására használnak. A TestCase az PHPUnit egyik beépített osztálya, amelyet az egységtesztek írásához kell használni. Az extends kulcsszóval ebből az osztályból származtathatunk saját teszteseteket, így kihasználva a PHPUnit által biztosított különféle tesztelési funkciókat.

Az use PHPUnit\Framework\TestCase; sorral megmondjuk a PHP-nak, hogy az egységtesztekhez használt osztályokat a PHPUnit\Framework névtér alól importáljuk, így lehetővé téve a TestCase osztály használatát a kódban anélkül, hogy minden alkalommal hosszú teljes névteret kellene használni. Ez a gyakorlat a kód tisztábbá és könnyebben érthetővé teszi. */
// Az osztály neve után következik a 'Test', ami segít azonosítani, hogy ezek a tesztek tartoznak az adott osztályhoz
final class DatabaseConnectionTest extends TestCase
{
    // Adatbázis kapcsolat létrehozásának tesztelése
    public function testDatabaseConnection(): void
    {
        // Adatbázis kapcsolat létrehozása
        $dbConnection = new DatabaseConnection();
        $dbconn = $dbConnection->getConnection();

        // Ellenőrizzük, hogy az adatbázis kapcsolat létrejött-e
        $this->assertInstanceOf(mysqli::class, $dbconn);
    }

    // Karakterkészlet beállításának tesztelése
    public function testCharacterSet(): void
    {
        // Adatbázis kapcsolat létrehozása
        $dbConnection = new DatabaseConnection();
        $dbconn = $dbConnection->getConnection();

        // Ellenőrizzük, hogy a karakterkészlet beállítása sikeres volt-e
        $this->assertTrue($dbconn->set_charset("utf8"));
    }
}
