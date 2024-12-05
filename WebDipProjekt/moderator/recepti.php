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
        $upit = "SELECT idrecept, naziv, postupak, trajanjepripreme, video, r.idkategorijejela 
        FROM recept r 
        LEFT JOIN moderira m 
        ON r.idkategorijejela=m.idkategorijejela
        WHERE m.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                <td>".$red['naziv']."</td>
                <td>".$red['postupak']."</td>
                <td>".$red['trajanjepripreme']."</td>
                <td><iframe width=200 height=200 src=\"".$red['video']."\"></iframe></td>
                <td>".ispisKategorije($red['idkategorijejela'])."</td>
                <td><a href=\"./noviRecept.php?id=".$red['idrecept']."\">Ažuriraj</a></td>
                <td><a href=\"./recept.php?id=".$red['idrecept']."\">Pregled</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Recepti</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <a href="./noviRecept.php">Dodaj recept</a>
            <table border=1>
                <tr>
                    <th>Naziv</th>
                    <th>Postupak</th>
                    <th>Trajanje pripreme</th>
                    <th>Video</th>
                    <th>Kategorija jela</th>
                </tr>
                <?php ispisRecepata(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>