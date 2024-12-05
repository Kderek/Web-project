<?php
    $naslov = "Kategorije jela";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    function ispisKategorija()
    {
        $upit = "SELECT idkategorijajela, naziv
        FROM kategorijajela";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td><a href=\"./novaKategorija.php?id=".$red['idkategorijajela']."\">Ažuriraj</a></td>
                <td><a href=\"./moderatoriKategorije.php?id=".$red['idkategorijajela']."\">Moderatori</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Kategorije jela</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <a href="./novaKategorija.php">Dodaj kategoriju</a>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                </tr>
                <?php ispisKategorija(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>