<?php
    $naslov = "Dodaj sastojak";
    $potrebnaUloga = 2;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['recept']))
    {
        header("Location: ./recepti.php");
    }

    if (isset($_POST['submit']))
    {
        $upit = "INSERT INTO sadrzi  
        VALUES ('".$_GET['recept']."', '".$_POST['sastojak']."', '".$_POST['kolicina']."', '".$_POST['mjernajedinica']."')";

        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->updateDB($upit);
        $veza->zatvoriDB();
        $dnevnik->spremiDnevnik(2, "Dodavanje sastojaka receptu", $upit, true);
        header("Location: ./recept.php?id=".$_GET['recept']."");
    }

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
                echo "<option value=\"".$red['idsastojak']."\">".$red['naziv']."</option>";
            }
        }
        $veza->zatvoriDB();
    }
?>
<div class="top-heading">
    <h1>Dodaj sastojak</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="dodajSastojak" method="post" action="">
                <label for="sastojak">Sastojak: </label>
                <select name="sastojak" id="sastojak">
                    <?php ispisSastojaka(); ?>
                </select>
                <br>
                <label for="kolicina">Količina: </label>
                <input name="kolicina" id="kolicina" type="number" placeholder="Količina"/>
                <br>
                <label for="mjernajedinica">Mjerna jedinica: </label>
                <input name="mjernajedinica" id="mjernajedinica" type="text" placeholder="Mjerna jedinica"/>
                <br>
                <input name="submit" type="submit" value="Dodaj sastojak"/>
            </form>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>