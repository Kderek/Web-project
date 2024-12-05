<?php
    $naslov = "Sastojci jela";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    function ispisSastojaka()
    {
        $upit = "SELECT idsastojak, naziv 
        FROM sastojak";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td><a href=\"./noviSastojak.php?id=".$red['idsastojak']."\">Ažuriraj</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Svi sastojci</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <a href="./noviSastojak.php">Dodaj sastojak</a>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                </tr>
                <?php ispisSastojaka(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>