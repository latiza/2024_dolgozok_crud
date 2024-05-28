<?php

//telepíteni: composer require --dev phpunit/phpunit

/**A declare(strict_types=1); egy PHP 7-ben bevezetett deklaráció, amely beállítja a szigorú típusellenőrzést az adott fájlban vagy blokkban. Amikor ezt a deklarációt használjuk, a PHP értékadásoknál és függvényhívásoknál is ellenőrzi a típusokat a deklarált típusok alapján, és hibát dob, ha nem megfelelő típust talál.

Például ha egy függvény paramétere típusként int-et vár, és mi string típusú változót adunk át neki, akkor a szigorú típusok beállításával a PHP hibát dob, mert a típus nem egyezik meg.

Ez segít a kód hibáinak korai felfedezésében és megakadályozza a hibás típusú értékek hibákat okozó futtatását. Ez különösen hasznos lehet nagyobb projektekben vagy csapatmunka során, ahol fontos a kód minősége és megbízhatósága. */
declare(strict_types=1);

// namespace importálása a PHPUnit keretrendszerből.
use PHPUnit\Framework\TestCase;

// A tesztelt osztály beolvasása
require_once 'kapcsolatOOP.php';

/**A PHPUnit egy népszerű PHP tesztelési keretrendszer, amelyet leginkább egységtesztek írására használnak. A TestCase az PHPUnit egyik beépített osztálya, amelyet az egységtesztek írásához kell használni. Az extends kulcsszóval ebből az osztályból származtathatunk saját teszteseteket, így kihasználva a PHPUnit által biztosított különféle tesztelési funkciókat.

Az use PHPUnit\Framework\TestCase; sorral megmondjuk a PHP-nak, hogy az egységtesztekhez használt osztályokat a PHPUnit\Framework névtér alól importáljuk, így lehetővé téve a TestCase osztály használatát a kódban anélkül, hogy minden alkalommal hosszú teljes névteret kellene használni. Ez a gyakorlat a kód tisztábbá és könnyebben érthetővé teszi. */
// Az osztály neve után következik a 'Test', ami segít azonosítani, hogy ezek a tesztek tartoznak az adott osztályhoz
final class DatabaseConnectionTest extends TestCase
{
    // Ez a teszt ellenőrzi, hogy létrehozható-e a DatabaseConnection objektum
    public function testCanCreateDatabaseConnection(): void
    {
        // Az osztály példányosítása
        $dbConnection = new DatabaseConnection();
        // Ellenőrizzük, hogy a példányt létrehozták-e (helyes típusú-e)
        $this->assertInstanceOf(DatabaseConnection::class, $dbConnection);
    }

    // Ez a teszt ellenőrzi, hogy a getConnection metódus visszaadja-e az adatbázis kapcsolatot
    public function testCanGetConnection(): void
    {
        // Az osztály példányosítása
        $dbConnection = new DatabaseConnection();
        // Adatbázis kapcsolat lekérése
        $dbconn = $dbConnection->getConnection();
        // Ellenőrizzük, hogy az adatbázis kapcsolat helyes típusú-e (mysqli objektum)
        $this->assertInstanceOf(mysqli::class, $dbconn);
    }

    // Ez a teszt ellenőrzi, hogy az adatbázis kapcsolat nem null
    public function testConnectionIsNotNull(): void
    {
        // Az osztály példányosítása
        $dbConnection = new DatabaseConnection();
        // Adatbázis kapcsolat lekérése
        $dbconn = $dbConnection->getConnection();
        // Ellenőrizzük, hogy az adatbázis kapcsolat nem null
        $this->assertNotNull($dbconn);
    }
}
