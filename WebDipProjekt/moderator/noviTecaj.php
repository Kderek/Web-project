<?php
    $naslov = "Novi recept";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

    $id = -1;
    $naziv = "";
    $brojprijava = 0;
    $rokprijave = "";
    $pocetak = "";
    $zavrsetak = "";
    $recept = 0;
    if (isset($_GET['id']))
    {
        $upit = "SELECT naziv, brojprijava, rokprijave, pocetak, zavrsetak, idrecepta 
        FROM tecaj 
        WHERE idtecaj='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        if ($red = mysqli_fetch_array($rezultat))
        {
            $id = $_GET['id'];
            $naziv = $red['naziv'];
            $brojprijava = $red['brojprijava'];
            $rokprijave = $red['rokprijave'];
            $pocetak = $red['pocetak'];
            $zavrsetak = $red['zavrsetak'];
            $recept = $red['idrecepta'];
        }
        $veza->zatvoriDB();
    }

    if (isset($_POST['submit']))
    {
        $upit = "";
        if ($id == -1)
        {
            $upit = "INSERT INTO tecaj
            VALUES (DEFAULT, '".$_POST['naziv']."', '".$_POST['brojprijava']."', '".$_POST['rokprijave']."', '".$_POST['pocetak']."', '".$_POST['zavrsetak']."', '".$_POST['recept']."')";
        }
        else
        {
            $upit = "UPDATE tecaj 
            SET `naziv`='".$_POST['naziv']."', 
            `brojprijava`='".$_POST['brojprijava']."', 
            `rokprijave`='".$_POST['rokprijave']."', 
            `pocetak`='".$_POST['pocetak']."', 
            `zavrsetak`='".$_POST['zavrsetak']."', 
            `idrecepta`='".$_POST['recept']."'   
            WHERE `idtecaj`='".$_GET['id']."'";
        }
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $veza->zatvoriDB();
        $dnevnik->spremiDnevnik(2, "Dodavanje/ažuriranje tečaja", $upit, true);
        header("Location: ./tecajevi.php");
    }

    function ispisRecepata()
    {
        global $recept;
        $upit = "SELECT idrecept, naziv 
        FROM recept 
        WHERE idkorisnika='".$_SESSION[Sesija::KORISNIK]."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                if ($recept != 0 && $recept==$red['idrecept'])
                    echo "<option value=\"".$red['idrecept']."\" selected>".$red['naziv']."</option>";
                else
                    echo "<option value=\"".$red['idrecept']."\">".$red['naziv']."</option>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Novi tečaj</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="novaKategorija" method="post" action="">
                <label for="naziv">Naziv: </label>
                <input name="naziv" id="naziv" type="text" placeholder="Naziv" autofocus value="<?php echo $naziv ?>"/>
                <br>
                <label for="brojprijava">Broj prijava: </label>
                <input name="brojprijava" id="brojprijava" type="number" placeholder="Broj prijava" value="<?php echo $brojprijava ?>"/>
                <br>
                <label for="rokprijave">Rok prijave:</label>
                <input type="date" id="rokprijave" name="rokprijave" value="<?php echo $rokprijave ?>"/>
                <br>
                <label for="pocetak">Početak:</label>
                <input type="date" id="pocetak" name="pocetak" value="<?php echo $pocetak ?>"/>
                <br>
                <label for="zavrsetak">Završetak:</label>
                <input type="date" id="zavrsetak" name="zavrsetak" value="<?php echo $zavrsetak ?>"/>
                <br>
                <label for="recept">Recept: </label>
                <select name="recept" id="recept">
                    <?php ispisRecepata(); ?>
                </select>
                <br>
                <input name="submit" type="submit" value="Novi tečaj"/>
            </form>
        </div>
    </div>
</div>


<?php
    require "../neregistrirani/podnozje.php";
?>