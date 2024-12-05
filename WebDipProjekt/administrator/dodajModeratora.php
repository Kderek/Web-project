<?php
    $naslov = "Dodaj moderatora";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['kategorija']) || !isset($_GET['mod']))
        header("Location: ./kategorijeJela.php");

    $upit = "INSERT INTO moderira 
    VALUES ('".$_GET['kategorija']."','".$_GET['mod']."')";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->updateDB($upit);

    $dnevnik->spremiDnevnik(2, "Dodavanje moderatora", $upit, true);
    header("Location: ./moderatoriKategorije.php?id=".$_GET['kategorija']."");
?>