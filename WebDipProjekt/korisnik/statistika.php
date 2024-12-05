<?php
    $naslov = "Statistika";
    $potrebnaUloga = 1;
    require "../neregistrirani/zaglavlje.php";

    function ispisKategorije($idKategorije)
    {
        $upit = "SELECT naziv 
        FROM kategorijajela
        WHERE idkategorijajela='$idKategorije'";
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

    function ispisStatistikeKorisnika()
    {
        $upit = "SELECT r.idkategorijejela, COUNT(p.ocjena) AS polozeno
        FROM prijava p
        RIGHT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        RIGHT JOIN recept r
        ON t.idrecepta=r.idrecept
        WHERE p.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'
        AND p.ocjena>=2
        GROUP BY r.idkategorijejela";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".ispisKategorije($red['idkategorijejela'])."</td>
                <td>".$red['polozeno']."</td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
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

    function ispisStatistikeModeratora()
    {
        $upit = "SELECT p.idtecaja, COUNT(p.ocjena) AS polozeno
        FROM prijava p
        RIGHT JOIN tecaj t
        ON p.idtecaja=t.idtecaj
        RIGHT JOIN recept r
        ON t.idrecepta=r.idrecept
        WHERE r.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'
        AND p.ocjena>=2
        GROUP BY t.idtecaj";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
 
        while ($red = mysqli_fetch_array($rezultat)) 
        {
            if ($red)
            {
                echo "<tr>
                <td>".ispisTecaja($red['idtecaja'])."</td>
                <td>".$red['polozeno']."</td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <div class="bottom-heading">
                <h3>Položeni tečajevi</h3>
            </div>
            <table border=1>
                <tr>
                    <th>Kategorija jela</th>
                    <th>Broj položenih tečajeva</th>
                </tr>
                <?php ispisStatistikeKorisnika(); ?>
            </table>

<?php 
if ($_SESSION[Sesija::ULOGA] >= 2)
{
    echo "<div class=\"bottom-heading\">
    <h3>Položeni tečajevi po korisniku</h3>
    </div>";
    echo "<table border=1>
    <tr>
        <th>Tečaj</th>
        <th>Broj položenih tečajeva</th>
    </tr>";
    ispisStatistikeModeratora();
    echo "</table>";
}
?>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>