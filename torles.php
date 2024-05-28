
<?php
if (isset($_GET['id'])) {
    // Biztonsági ellenőrzés: Token alapú ellenőrzés hozzáadása
    // Ha a token helyes, folytathatjuk a törlési művelettel

    require("kapcsolat.php");
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM dolgozok
            WHERE id = {$id}";

    // Lekérdezés végrehajtása és hibakezelés
    if (mysqli_query($dbconn, $sql)) {
        // Sikeres törlés esetén átirányítás a lista oldalra
        header("Location: lista.php");
        exit(); // Megszakítjuk a további kód végrehajtását
    } else {
        // Hibakezelés: Hibaüzenet megjelenítése a felhasználónak
        echo "Hiba történt a dolgozó törlése során: " . mysqli_error($dbconn);
        // Esetleg egy visszatérési link megjelenítése
    }
} else {
    // Ha nincs 'id' paraméter az URL-ben, átirányít a lista oldalra
    header("Location: lista.php");
    exit(); // Megszakítjuk a további kód végrehajtását
}
?>
