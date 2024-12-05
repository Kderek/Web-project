<?php
    $naslov = "Tečajevi";
    $potrebnaUloga = 2;
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

    function ispisTecajeva()
    {
        $upit = "SELECT idtecaj, naziv, brojprijava, rokprijave, pocetak, zavrsetak, idrecepta 
        FROM tecaj";
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
                <td><a href=\"./noviTecaj.php?id=".$red['idtecaj']."\">Ažuriraj</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Tečajevi</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <a href="./noviTecaj.php">Dodaj tečaj</a>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Broj prijava</th>
                    <th>Rok prijave</th>
                    <th>Početak</th>
                    <th>Završetak</th>
                    <th>Recept</th>
                </tr>
                <?php ispisTecajeva(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>