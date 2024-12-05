<?php
    $naslov = "Prijavi tečaj";
    $potrebnaUloga = 1;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['tecaj']))
        header("Location: ./aktivniTecajevi.php");

    $upit = "INSERT INTO prijava 
    VALUES (DEFAULT, NULL, NULL, '".$_GET['tecaj']."', '".$_SESSION[Sesija::KORISNIK]."', NULL, NULL)";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->updateDB($upit);
    $veza->zatvoriDB();
    $dnevnik->spremiDnevnik(2, "Prijava tečaja", $upit, true);
    header("Location: ./aktivniTecajevi.php");
?>