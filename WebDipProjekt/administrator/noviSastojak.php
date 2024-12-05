<?php
    $naslov = "Novi sastojak";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    $id = -1;
    $naziv = "";
    if (isset($_GET['id']))
    {
        $upit = "SELECT naziv
        FROM sastojak 
        WHERE idsastojak='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        if ($red = mysqli_fetch_array($rezultat))
        {
            $id = $_GET['id'];
            $naziv = $red['naziv'];
        }
        $veza->zatvoriDB();
    }

    if (isset($_POST['submit']))
    {
        $upit = "";
        if ($id == -1)
        {
            $upit = "INSERT INTO sastojak
            VALUES (DEFAULT, '".$_POST['naziv']."')";
        }
        else
        {
            $upit = "UPDATE sastojak 
            SET naziv='".$_POST['naziv']."'
            WHERE idsastojak='$id'";
        }
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $veza->zatvoriDB();
        $dnevnik->spremiDnevnik(2, "Dodavanje/ažuriranje sastojka", $upit, true);
        header("Location: ./sastojciJela.php");
    }
?>
<div class="top-heading">
    <h1>Novi sastojak</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="noviSastojak" method="post" action="">
                <label for="naziv">Naziv: </label>
                <input name="naziv" id="naziv" name="naziv" type="text" placeholder="Naziv" autofocus value="<?php echo $naziv ?>"/>
                <br>
                <input name="submit" type="submit" value="Novi sastojak"/>
            </form>
        </div>
    </div>
</div>


<?php
    require "../neregistrirani/podnozje.php";
?>