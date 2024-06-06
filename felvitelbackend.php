<?php
header("Content-Type: application/json");

// Csak POST kéréseket fogadunk
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // JSON beolvasása
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Hibák tárolása
    $hibak = [];

    // Változók tisztítása és ellenőrzése
    $nev = htmlspecialchars(trim(ucwords(strtolower($input['nev']))));
    $mobil = htmlspecialchars(trim($input['mobil']));
    $email = strtolower(htmlspecialchars(trim($input['email'])));

    if (empty($nev)) {
        $hibak[] = "Nem adott meg nevet!";
    } elseif (strlen($nev) < 3) {
        $hibak[] = "Rossz nevet adott meg!";
    }

    if (empty($mobil) || strlen($mobil) < 9) {
        $hibak[] = "Rossz mobil számot adott meg!";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hibak[] = "Rossz e-mail címet adott meg!";
    }

    if (count($hibak) > 0) {
        echo json_encode(['success' => false, 'errors' => $hibak]);
    } else {
        // Adatbázis kapcsolat
        require("kapcsolat.php");

        $sql = "INSERT INTO dolgozok (nev, mobil, email) VALUES ('{$nev}', '{$mobil}', '{$email}')";

        if (mysqli_query($dbconn, $sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'errors' => ["Nem sikerült az adatbázis művelet"]]);
        }

        mysqli_close($dbconn);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ["Helytelen kérés"]]);
}
