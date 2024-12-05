<?php
    $naslov = "Recept";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['id']))
    {
        header("Location ./recepti.php");
    }

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

    function ispisPodataka()
    {
        $naziv = "";
        $postupak = "";
        $trajanjepripreme = 0;
        $video = "";
        $kategorijaJela = 0;
        $upit = "SELECT naziv, postupak, trajanjepripreme, video, idkategorijejela 
        FROM recept 
        WHERE idrecept='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        if ($red = mysqli_fetch_array($rezultat))
        {
            $naziv = $red['naziv'];
            $postupak = $red['postupak'];
            $trajanjepripreme = $red['trajanjepripreme'];
            $video = $red['video'];
            $kategorijaJela = $red['idkategorijejela'];
        }
        $veza->zatvoriDB();

        echo "Naziv: $naziv<br>";
        echo "Postupak: $postupak<br>";
        echo "Trajanje pripreme: $trajanjepripreme min<br>";
        echo "Video: <iframe width=200 height=200 src=\"".$video."\"></iframe><br>";
        echo "Kategorija: ".ispisKategorije($kategorijaJela)."<br>";
    }

    function ispisSastojka($idSastojka)
    {
        $upit = "SELECT naziv 
        FROM sastojak
        WHERE idsastojak='$idSastojka'";
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

    function ispisSastojaka()
    {
        $upit = "SELECT idsastojka, kolicina, jedinica 
        FROM sadrzi 
        WHERE idrecepta='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                    <td>".ispisSastojka($red['idsastojka'])."</td>
                    <td>".$red['kolicina']."</td>
                    <td>".$red['jedinica']."</td>
                    <td><a href=\"./ukloniSastojak.php?recept=".$_GET['id']."&sastojak=".$red['idsastojka']."\">Ukloni</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>
<div class="top-heading">
    <h1>Recept</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <?php ispisPodataka(); ?>
            <div class="bottom-heading">
                <h3>Sastojci</h3>
            </div>
            <a href="./dodajSastojak.php?recept=<?php echo $_GET['id'] ?>">Dodaj sastojak</a>
            <table border=1>
                <tr>
                    <th>Sastojak</th>
                    <th>Količina</th>
                    <th>Mjerna jedinica</th>
                </tr>
                <?php ispisSastojaka(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>