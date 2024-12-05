<?php
    $naslov = "Ocjenjivanje";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

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

    function ispisPrijava()
    {
        $upit = "SELECT idprijava, idtecaja, p.idkorisnika, vrijemeizrade, slika 
        FROM prijava p
        LEFT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        LEFT JOIN recept r
        ON t.idrecepta=r.idrecept
        WHERE r.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'
        AND p.ocjena IS NULL";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".ispisTecaja($red['idtecaja'])."</td>
                <td>".ispisKorisnika($red['idkorisnika'])."</td>
                <td>".$red['vrijemeizrade']."</td>
                <td><img src=\"../slike/".$red['slika']."\" width=100 height=100/></td>
                <td><a href=\"./ocjeniPrijavu.php?id=".$red['idprijava']."\">Ocjeni</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Ocjenjivanje</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <table border=1>
                <tr>
                    <th>Naziv tečaja</th>
                    <th>Korisnik</th>
                    <th>Vrijeme izrade</th>
                    <th>Slika</th>
                </tr>
                <?php ispisPrijava(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>