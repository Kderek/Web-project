<?php
    require "../klase/baza.class.php";
    require "../klase/dnevnik.class.php";
    require "../klase/sesija.class.php";
    $dnevnik = new Dnevnik();
    Sesija::kreirajSesiju();

    if (isset($potrebnaUloga) && $potrebnaUloga != 0)
        if (!isset($_SESSION[Sesija::ULOGA]) || $_SESSION[Sesija::ULOGA] < $potrebnaUloga)
            header ("Location: ../neregistrirani/index.php");

    function navigacija()
    {
        echo "<div class=\"nav-link\"><a href=\"../neregistrirani/index.php\">Početna stranica</a></div>";
        echo "<div class=\"nav-link\"><a href=\"../neregistrirani/galerija.php\">Galerija</a></div>";
        if (!isset($_SESSION[Sesija::ULOGA]) || $_SESSION[Sesija::ULOGA] == 0)
            echo "<div class=\"nav-link\"><a href=\"../neregistrirani/prijava.php\">Prijava</a></div>";
        else
            echo "<div class=\"nav-link\"><a href=\"../korisnik/odjava.php\">Odjava</a></div>";

        if (isset($_SESSION[Sesija::ULOGA]) && $_SESSION[Sesija::ULOGA] >= 1) //korisnik
        {
            echo "<div class=\"nav-link\"><a href=\"../korisnik/aktivniTecajevi.php\">Aktivni tečajevi</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../korisnik/statistika.php\">Statistika</a></div>";
        }

        if (isset($_SESSION[Sesija::ULOGA]) && $_SESSION[Sesija::ULOGA] >= 2) //moderator
        {
            echo "<div class=\"nav-link\"><a href=\"../moderator/recepti.php\">Recepti</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../moderator/tecajevi.php\">Tečajevi</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../moderator/analizaRecepata.php\">Analiza recepata</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../moderator/ocjenjivanje.php\">Ocjenjivanje</a></div>";
        }

        if (isset($_SESSION[Sesija::ULOGA]) && $_SESSION[Sesija::ULOGA] == 3) //admin
        {
            echo "<div class=\"nav-link\"><a href=\"../administrator/kategorijeJela.php\">Kategorije jela</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../administrator/sastojciJela.php\">Sastojci jela</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../administrator/korisnickiRacuni.php\">Korisnički računi</a></div>";
            echo "<div class=\"nav-link\"><a href=\"../administrator/dnevnik.php\">Dnevnik</a></div>";
        }
        echo "<br><div class=\"nav-link\"><a href=\"../neregistrirani/dokumentacija.html\">Dokumentacija</a></div>";
        echo "<div class=\"nav-link\"><a href=\"../neregistrirani/o_autoru.html\">O autoru</a></div>";
    }
?>

<!DOCTYPE html>
<html lang="hr">
    <head>
        <title><?php echo $naslov ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100;600&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/551aba8a7d.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../nav.css"/>
        
    </head>
    <body>
    <div  class="navigacija-sve" id="box1">
      
      <div class="center-column">
          <div class="banner-image">
              <?php echo $naslov ?>
          </div>
          <div class="link">
              <?php navigacija(); ?>
        </div>
      </div>
    </div>         
        <div>