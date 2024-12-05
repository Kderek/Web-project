<?php
    $naslov = "Ukloni moderatora";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['kategorija']) || !isset($_GET['mod']))
        header("Location: ./kategorijeJela.php");

    $upit = "DELETE FROM moderira 
    WHERE idkategorijejela='".$_GET['kategorija']."' 
    AND idkorisnika='".$_GET['mod']."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->updateDB($upit);
    $veza->zatvoriDB();
    $dnevnik->spremiDnevnik(2, "Uklanjanje moderatora", $upit, true);
    header("Location: ./moderatoriKategorije.php?id=".$_GET['kategorija']."");
?>