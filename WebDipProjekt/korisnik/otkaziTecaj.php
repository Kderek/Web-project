<?php
    $naslov = "Otkaži tecaj";
    $potrebnaUloga = 1;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['tecaj']))
        header("Location: ./aktivniTecajevi.php");

    $upit = "DELETE FROM prijava 
    WHERE idtecaja='".$_GET['tecaj']."' 
    AND idkorisnika='".$_SESSION[Sesija::KORISNIK]."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->updateDB($upit);
    $veza->zatvoriDB();
    $dnevnik->spremiDnevnik(2, "Otkazivanje tečaja", $upit, true);
    header("Location: ./aktivniTecajevi.php");
?>