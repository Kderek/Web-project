<?php
    $naslov = "Aktivacija";
    $potrebnaUloga = 0;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['korime']) || !isset($_GET['kod']))
    {
        header("Location: ./index.php");
    }

    $upit = "SELECT idkorisnik, korisnickoime, aktivacijskiKod, datumregistracije 
            FROM korisnik 
            WHERE korisnickoime='".$_GET['korime']."' 
            AND aktivacijskiKod='".$_GET['kod']."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->selectDB($upit);
    if ($red = mysqli_fetch_array($rezultat))
    {
        $prosloVremena = (time()-strtotime($red['datumregistracije']))/3600;
        if ($prosloVremena < 7)
        {
            $upit = "UPDATE korisnik 
                    SET aktivan='1' 
                    WHERE korisnickoime='".$_GET['korime']."'";
            $veza->updateDB($upit);
            $veza->zatvoriDB();
            $dnevnik->spremiDnevnik(2, "Aktivacija računa", $upit, true);
            echo "Račun je aktiviran!<br>";
        }
        else
        {
            echo "Istekao je aktivacijski kod!<br>";
        }
    }
?>



<?php
    require "../neregistrirani/podnozje.php";
?>