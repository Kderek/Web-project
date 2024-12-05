<?php
    $naslov = "Novi recept";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

    $id = -1;
    $naziv = "";
    $postupak = "";
    $trajanjepripreme = 0;
    $video = "";
    $kategorijaJela = 0;

    if (isset($_GET['id']))
    {
        $upit = "SELECT naziv, postupak, trajanjepripreme, video, idkategorijejela 
        FROM recept 
        WHERE idrecept='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        if ($red = mysqli_fetch_array($rezultat))
        {
            $id = $_GET['id'];
            $naziv = $red['naziv'];
            $postupak = $red['postupak'];
            $trajanjepripreme = $red['trajanjepripreme'];
            $video = $red['video'];
            $kategorijaJela = $red['idkategorijejela'];
        }
        $veza->zatvoriDB();
    }

    if (isset($_POST['submit']))
    {
        $upit = "";
        if ($id == -1)
        {
            $upit = "INSERT INTO recept  
            VALUES (DEFAULT, '".$_POST['naziv']."', '".$_POST['postupak']."', '".$_POST['trajanjepripreme']."', '".$_POST['video']."', '".$_POST['kategorija']."', '".$_SESSION[Sesija::KORISNIK]."')";
        }
        else
        {
            $upit = "UPDATE recept 
            SET `naziv`='".$_POST['naziv']."', 
            `postupak`='".$_POST['postupak']."', 
            `trajanjepripreme`='".$_POST['trajanjepripreme']."', 
            `video`='".$_POST['video']."', 
            `idkategorijejela`='".$_POST['kategorija']."'  
            WHERE `idrecept`='".$_GET['id']."'";
        }
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $veza->zatvoriDB();
        $dnevnik->spremiDnevnik(2, "Dodavanje/ažuriranje recepta", $upit, true);
        header("Location: ./recepti.php");
    }

    function ispisKategorija()
    {
        global $kategorijaJela;
        $upit = "SELECT idkategorijajela, naziv 
        FROM kategorijajela k
        LEFT JOIN moderira m
        ON k.idkategorijajela=m.idkategorijejela
        WHERE m.idkorisnika='".$_SESSION[Sesija::KORISNIK]."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                if ($kategorijaJela != 0 && $kategorijaJela == $red['idkategorijajela'])
                    echo "<option value=\"".$red['idkategorijajela']."\" selected>".$red['naziv']."</option>";
                else
                    echo "<option value=\"".$red['idkategorijajela']."\">".$red['naziv']."</option>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Novi recept</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="novaKategorija" method="post" action="">
                <label for="naziv">Naziv: </label>
                <input name="naziv" id="naziv" type="text" placeholder="Naziv" autofocus value="<?php echo $naziv ?>"/>
                <br>
                <label for="postupak">Postupak: </label>
                <textarea name="postupak" id="postupak" type="text" placeholder="Postupak" rows="5" cols="50"><?php echo $postupak ?></textarea>
                <br>
                <label for="trajanjepripreme">Trajanje pripreme: </label>
                <input name="trajanjepripreme" id="trajanjepripreme" type="number" placeholder="Trajanje pripreme" value="<?php echo $trajanjepripreme ?>"/>min
                <br>
                <label for="video">Video: </label>
                <input name="video" id="video" type="text" placeholder="Video" value="<?php echo $video ?>"/>
                <br>
                <label for="kategorija">Kategorija jela: </label>
                <select name="kategorija" id="kategorija">
                    <?php ispisKategorija(); ?>
                </select>
                <br>
                <input name="submit" type="submit" value="Novi recept"/>
            </form>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>