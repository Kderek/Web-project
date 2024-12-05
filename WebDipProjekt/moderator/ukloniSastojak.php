<?php
    $naslov = "Ukloni sastojak";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['recept']) || !isset($_GET['sastojak']))
        header("Location: ./recepti.php");

    $upit = "DELETE FROM sadrzi 
    WHERE idrecepta='".$_GET['recept']."' 
    AND idsastojka='".$_GET['sastojak']."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->updateDB($upit);
    $veza->zatvoriDB();
    $dnevnik->spremiDnevnik(2, "Brisanje sastojka iz recepta", $upit, true);
    header("Location: ./recept.php?id=".$_GET['recept']."");
?>