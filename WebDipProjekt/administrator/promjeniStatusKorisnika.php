<?php
    $naslov = "Promjeni status korisnika";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['id']) || !isset($_GET['status']))
        header("Location: ./korisnickiRacuni.php");

    $noviStatus = 0;
    if ($_GET['status'] == 0)
        $noviStatus = 1;
    $upit = "UPDATE korisnik SET 
    aktivan='$noviStatus' 
    WHERE idkorisnik='".$_GET['id']."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->updateDB($upit);
    $veza->zatvoriDB();
    $dnevnik->spremiDnevnik(2, "Promjena statusa korisnika", $upit, true);
    header("Location: ./korisnickiRacuni.php");
?>