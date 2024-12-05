<?php
    $naslov = "Ocjeni prijavu";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['id']))
    {
        header("Location: ./ocjenjivanje.php");
    }

    if (isset($_POST['submit']))
    {
        $upit = "UPDATE prijava SET 
        ocjena='".$_POST['ocjena']."', 
        komentar='".$_POST['komentar']."' 
        WHERE idprijava='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $veza->zatvoriDB();
        $dnevnik->spremiDnevnik(2, "Ocjenjivanje prijave", $upit, true);
        header("Location: ./ocjenjivanje.php?");
    }

    function ispisTecaja($idTecaja)
    {
        $upit = "SELECT naziv 
        FROM tecaj
        WHERE idtecaj='$idTecaja'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        if ($red = mysqli_fetch_array($rezultat))
        {
            $veza->zatvoriDB();
            return $red['naziv'];
        }
        $veza->zatvoriDB();
        return "";
    }
    function ispisKorisnika($idKorisnika)
    {
        $upit = "SELECT ime, prezime 
        FROM korisnik
        WHERE idkorisnik='$idKorisnika'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        if ($red = mysqli_fetch_array($rezultat))
        {
            $veza->zatvoriDB();
            return $red['prezime']." ".$red['ime'];
        }
        $veza->zatvoriDB();
        return "";
    }

    function ispisPodataka()
    {
        $upit = "SELECT idprijava, idtecaja, p.idkorisnika, vrijemeizrade, slika 
        FROM prijava p
        LEFT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        LEFT JOIN recept r
        ON t.idrecepta=r.idrecept
        WHERE p.idprijava='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        if ($red = mysqli_fetch_array($rezultat))
        {
            echo "Tečaj: ".ispisTecaja($red['idtecaja'])."<br>
            Korisnik: ".ispisKorisnika($red['idkorisnika'])."<br>
            Vrijeme izrade: ".$red['vrijemeizrade']."<br>
            Slika: ".$red['slika']."<br>";
        }
        $veza->zatvoriDB();
    }
?>
<div class="top-heading">
    <h1>Ocjena prijave</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <?php ispisPodataka(); ?>

            <form name="ocjeni" method="post" action="">
                <label for="ocjena">Ocjena: </label>
                <input name="ocjena" id="ocjena" type="number" min="1" max="5" placeholder="Ocjena"/>
                <br>
                <label for="komentar">Komentar: </label>
                <input name="komentar" id="komentar" type="text" placeholder="Komentar"/>
                <br>
                <input name="submit" type="submit" value="Ocjeni"/>
            </form>
        </div>
    </div>
</div>


<?php
    require "../neregistrirani/podnozje.php";
?>