<?php
    $naslov = "Aktivni Tečajevi";
    $potrebnaUloga = 1;
    require "../neregistrirani/zaglavlje.php";

    function ispisRecepta($idRecepta)
    {
        $upit = "SELECT naziv 
        FROM recept
        WHERE idrecept='$idRecepta'";
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

    function ispisOcjenjenihTecajeva()
    {
        $upit = "SELECT p.idprijava, p.vrijemeizrade, p.slika, p.ocjena, p.komentar, t.idtecaj, t.naziv, t.brojprijava, t.rokprijave, t.pocetak, t.zavrsetak, t.idrecepta 
        FROM prijava p 
        LEFT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        WHERE p.idkorisnika='".$_SESSION[Sesija::KORISNIK]."' 
        AND p.ocjena IS NOT NULL";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td>".$red['brojprijava']."</td>
                <td>".$red['rokprijave']."</td>
                <td>".$red['pocetak']."</td>
                <td>".$red['zavrsetak']."</td>
                <td>".ispisRecepta($red['idrecepta'])."</td>
                <td>".$red['vrijemeizrade']."</td>
                <td><img src=\"../slike/".$red['slika']."\" width=100 height=100/></td>
                <td>".$red['ocjena']."</td>
                <td>".$red['komentar']."</td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }

    function ispisAktivnihTecajeva()
    {
        $upit = "SELECT p.idprijava, p.vrijemeizrade, p.slika, t.idtecaj, t.naziv, t.brojprijava, t.rokprijave, t.pocetak, t.zavrsetak, t.idrecepta 
        FROM prijava p 
        LEFT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        WHERE p.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'
        AND p.ocjena IS NULL";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red && $red['pocetak'] < date("Y-m-d H:i:s"))
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td>".$red['brojprijava']."</td>
                <td>".$red['rokprijave']."</td>
                <td>".$red['pocetak']."</td>
                <td>".$red['zavrsetak']."</td>
                <td>".ispisRecepta($red['idrecepta'])."</td>
                <td>".$red['vrijemeizrade']."</td>
                <td><img src=\"../slike/".$red['slika']."\" width=100 height=100/></td>";
                if ($red['zavrsetak'] > date("Y-m-d H:i:s")) 
                    echo "<td><a href=\"aktivniRecept.php?id=".$red['idprijava']."\">Recept</a></td>";
                echo "</tr>";
            }
        }
        $veza->zatvoriDB();
    }

    function ispisPrijavljenihTecajeva()
    {
        $upit = "SELECT p.idprijava, t.idtecaj, t.naziv, t.brojprijava, t.rokprijave, t.pocetak, t.zavrsetak, t.idrecepta 
        FROM prijava p 
        LEFT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        WHERE p.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'
        AND p.ocjena IS NULL";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red && $red['pocetak'] > date("Y-m-d H:i:s"))
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td>".$red['brojprijava']."</td>
                <td>".$red['rokprijave']."</td>
                <td>".$red['pocetak']."</td>
                <td>".$red['zavrsetak']."</td>
                <td>".ispisRecepta($red['idrecepta'])."</td>";
                echo "<td><a href=\"./otkaziTecaj.php?tecaj=".$red['idtecaj']."\">Otkaži</a></td>";
                echo "</tr>";
            }
        }
        $veza->zatvoriDB();
    }
    function ispisNeprijavljenihTecajeva()
    {
        $upit = "SELECT idtecaj, naziv, brojprijava, rokprijave, pocetak, zavrsetak, idrecepta 
        FROM tecaj t 
        WHERE NOT EXISTS (
            SELECT *
            FROM prijava p 
            WHERE p.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'
            AND p.idtecaja=t.idtecaj
        )";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                $imaMjesta = true;
                $upit = "SELECT COUNT(*) AS brojprijava
                FROM prijava 
                WHERE idtecaja='".$red['idtecaj']."'";
                $rezultat2 = $veza->selectDB($upit);
                if ($red2 = mysqli_fetch_array($rezultat2))
                {
                    if ($red2['brojprijava'] >= $red['brojprijava'])
                        $imaMjesta = false;
                }

                echo "<tr>
                <td>".$red['naziv']."</td>
                <td>".$red['brojprijava']."</td>
                <td>".$red['rokprijave']."</td>
                <td>".$red['pocetak']."</td>
                <td>".$red['zavrsetak']."</td>
                <td>".ispisRecepta($red['idrecepta'])."</td>";
                if ($red['rokprijave'] > date("Y-m-d H:i:s") && $imaMjesta) echo "<td><a href=\"./prijaviTecaj.php?tecaj=".$red['idtecaj']."\">Prijavi</a></td>";
                echo "</tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Aktivni tečajevi</h1>
</div>

<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <div class="bottom-heading">
                <h3>Ocjenjeni tečajevi</h3>
            </div>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Broj prijava</th>
                    <th>Rok prijave</th>
                    <th>Početak</th>
                    <th>Završetak</th>
                    <th>Recept</th>
                    <th>Vrijeme izrade</th>
                    <th>Slika</th>
                    <th>Ocjena</th>
                    <th>Komentar</th>
                </tr>
                <?php ispisOcjenjenihTecajeva(); ?>
            </table>

            <div class="bottom-heading">
                <h3>Aktivni tečajevi</h3>
            </div>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Broj prijava</th>
                    <th>Rok prijave</th>
                    <th>Početak</th>
                    <th>Završetak</th>
                    <th>Recept</th>
                    <th>Vrijeme izrade</th>
                    <th>Slika</th>
                </tr>
                <?php ispisAktivnihTecajeva(); ?>
            </table>

            <div class="bottom-heading">
                <h3>Prijavljeni tečajevi</h3>
            </div>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Broj prijava</th>
                    <th>Rok prijave</th>
                    <th>Početak</th>
                    <th>Završetak</th>
                    <th>Recept</th>
                </tr>
                <?php ispisPrijavljenihTecajeva(); ?>
            </table>

            <div class="bottom-heading">
                <h3>Neprijavljeni tečajevi</h3>
            </div>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Broj prijava</th>
                    <th>Rok prijave</th>
                    <th>Početak</th>
                    <th>Završetak</th>
                    <th>Recept</th>
                </tr>
                <?php ispisNeprijavljenihTecajeva(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>