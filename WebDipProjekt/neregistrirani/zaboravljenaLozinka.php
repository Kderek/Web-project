<?php
    $naslov = "Zaboravljena lozinka";
    $potrebnaUloga = 0;
    require "./zaglavlje.php";
    $greska = "";
    function generirajLozinku()
    {
        $znakovi = "0123456789abcdefghijklmnopqrstuvwxyz";
        $lozinka = "";
        for ($i = 0; $i < 5; $i++) {
            $lozinka .= $znakovi[rand(0, strlen($znakovi) - 1)];
        }
        return $lozinka;
    }

    if (isset($_POST['submit']))
    {
        $postojiKorisnik = false;
        $upit = "SELECT idkorisnik 
        FROM korisnik 
        WHERE email='".$_POST['email']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        if ($red = mysqli_fetch_array($rezultat))
        {
            $postojiKorisnik = true;
        }
        $veza->zatvoriDB();

        if ($postojiKorisnik)
        {
            $lozinka = generirajLozinku();
            $sha = hash("sha256", $lozinka);
            $upit = "UPDATE korisnik SET 
            lozinka='$lozinka', 
            sha='$sha' 
            WHERE email='".$_POST['email']."'";
            $veza = new Baza();
            $veza->spojiDB();
            $rezultat = $veza->updateDB($upit);
            $veza->zatvoriDB();
            mail($_POST['email'],"Promjena lozinke", "Nova lozinka: $lozinka");
            $dnevnik->spremiDnevnik(2, "Zaboravljena lozinka", $upit, true);
        }
        else
        {
            $greska .= "Kriva e-mail adresa!<br>";
        }
    }
?>
<div class="top-heading">
    <h1>Zaboravljena lozinka</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <?php echo $greska; ?>

            <form name="zaboravljenaLozinka" method="post" action="">
                <label for="email">E-mail: </label>
                <input name="email" id="email" name="email" type="text" placeholder="E-mail" autofocus/>
                <br>
                <input name="submit" type="submit" value="Nova lozinka"/>
            </form>
        </div>
    </div>
</div>

<?php
    require "./podnozje.php";
?>