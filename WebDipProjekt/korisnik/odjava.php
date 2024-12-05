<?php
    $naslov = "Odjava";
    $potrebnaUloga = 1;
    require "../neregistrirani/zaglavlje.php";

    $dnevnik->spremiDnevnik(1, "Odjava", null, true);
    Sesija::kreirajKorisnika("");
    header("Location: ../neregistrirani/index.php");
?>