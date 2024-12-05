<?php
    $naslov = "Recepti";
    $potrebnaUloga = 2;
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

    function ispisRecepata()
    {
        $upit = "SELECT r.naziv, trajanjepripreme, AVG(p.vrijemeizrade) as prosjek
        FROM recept r
        LEFT JOIN tecaj t
        ON r.idrecept=t.idrecepta
        LEFT JOIN prijava p
        ON t.idtecaj=p.idtecaja
        WHERE r.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td>".$red['trajanjepripreme']." min</td>
                <td>".number_format($red['prosjek'], 2)." min</td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Analiza recepata</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Vrijeme pripreme</th>
                    <th>Prosječno vrijeme korisnika</th>
                </tr>
                <?php ispisRecepata(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>