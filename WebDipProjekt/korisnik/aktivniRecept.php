<?php
    $naslov = "Aktivni Recept";
    $potrebnaUloga = 1;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['id']))
    {
        header("Location ./aktivniTecajevi.php");
    }
    $idRecepta = 0;
    $upit = "SELECT t.idrecepta
    FROM prijava p
    LEFT JOIN tecaj t
    ON p.idtecaja=t.idtecaj
    WHERE p.idprijava='".$_GET['id']."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->selectDB($upit);
    if ($red = mysqli_fetch_array($rezultat))
    {
        $idRecepta=$red['idrecepta'];
    }
    $veza->zatvoriDB();

    if(isset($_POST['submit']))
    {
        $novaDat = "../slike/";
        $nazivSlike = $_POST['slika'];
        $nazivSlike .= ".".strtolower(pathinfo(basename($_FILES["datoteka"]["name"]), PATHINFO_EXTENSION));
        $novaDat .= $nazivSlike;
        move_uploaded_file($_FILES["datoteka"]["tmp_name"], $novaDat);

        $upit = "UPDATE prijava SET 
        vrijemeizrade='".$_POST['vrijemeizrade']."', 
        slika='".$nazivSlike."' 
        WHERE idprijava='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $veza->zatvoriDB();
        $dnevnik->spremiDnevnik(2, "Ažuriranje prijave", $upit, true);
        header("Location: ./aktivniTecajevi.php");
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
        global $idRecepta;
        $naziv = "";
        $postupak = "";
        $trajanjepripreme = 0;
        $video = "";
        $kategorijaJela = 0;
        $upit = "SELECT naziv, postupak, trajanjepripreme, video, idkategorijejela 
        FROM recept 
        WHERE idrecept='".$idRecepta."'";
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
        echo "Video: <iframe width=200 height=200 src=\"$video\"></iframe><br>";
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
        global $idRecepta;
        $upit = "SELECT idsastojka, kolicina, jedinica 
        FROM sadrzi 
        WHERE idrecepta='".$idRecepta."'";
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
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Recept</h1>
</div>
<?php ispisPodataka(); ?>
<div class="bottom-heading">
    <h3>Sastojci</h3>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <table border=1>
                <tr>
                    <th>Sastojak</th>
                    <th>Količina</th>
                    <th>Mjerna jedinica</th>
                </tr>
                <?php ispisSastojaka(); ?>
            </table>
            <br>
            <form name="gotovRecept" method="post" action="" enctype="multipart/form-data">
                <label for="vrijemeizrade">Vrijeme izrade: </label>
                <input name="vrijemeizrade" id="vrijemeizrade" type="number" placeholder="Vrijeme izrade" autofocus/>min
                <br>
                <label for="datoteka">Slika: </label>
                <input type='file' name="datoteka"/>
                <input type='hidden' name='MAX_FILE_SIZE' value='3000000'/><br>
                <br>
                <label for="slika">Naziv slike: </label>
                <input name="slika" id="slika" type="text" placeholder="Slika" />
                <br>
                <input name="submit" type="submit" value="Dodaj sliku"/>
            </form>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>