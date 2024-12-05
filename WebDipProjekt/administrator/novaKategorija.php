<?php
    $naslov = "Nova kategorija";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    $id = -1;
    $naziv = "";
    if (isset($_GET['id']))
    {
        $upit = "SELECT naziv
        FROM kategorijajela 
        WHERE idkategorijajela='".$_GET['id']."'";
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
            $upit = "INSERT INTO kategorijajela
            VALUES (DEFAULT, '".$_POST['naziv']."')";
        }
        else
        {
            $upit = "UPDATE kategorijajela 
            SET naziv='".$_POST['naziv']."'
            WHERE idkategorijajela='$id'";
        }
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $dnevnik->spremiDnevnik(2, "Dodavanje/Ažuriranje jela", $upit, true);
        $veza->zatvoriDB();
        header("Location: ./kategorijeJela.php");
    }
?>

<div class="top-heading">
    <h1>Nova kategorija jela</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="novaKategorija" method="post" action="">
                <label for="naziv">Naziv: </label>
                <input name="naziv" id="naziv" name="naziv" type="text" placeholder="Naziv" autofocus value="<?php echo $naziv ?>"/>
                <br>
                <input name="submit" type="submit" value="Nova kategorija"/>
            </form>
        </div>
    </div>
</div>


<?php
    require "../neregistrirani/podnozje.php";
?>