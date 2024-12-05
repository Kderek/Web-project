<?php
    $naslov = "Prijava";
    $potrebnaUloga = 0;
    require "./zaglavlje.php";

    if($_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }

    if (isset($_POST['submit']))
    {
        $sha = hash("sha256", $_POST['lozinka']);
        $upit = "SELECT idkorisnik, iduloge, aktivan 
        FROM korisnik 
        WHERE korisnickoime='".$_POST['korIme']."' 
        AND sha='$sha'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        
        if ($red = mysqli_fetch_array($rezultat))
        {
            if ($red['aktivan'] == 1)
            {
                Sesija::kreirajKorisnika($red['idkorisnik'], $red['iduloge']);
                $upit = "UPDATE korisnik 
                SET neuspjesneprijave='0'
                WHERE idkorisnik='".$red['idkorisnik']."'";
                $veza->updateDB($upit);
                $veza->zatvoriDB();
                $dnevnik->spremiDnevnik(1, "Prijava", $upit, true);

                if(isset($_POST['zapamti']))
                {
                    setcookie("zapamti", $_POST['korIme']);
                }
                else
                {
                    setcookie("zapamti", "");
                }

                header("Location: ./index.php");
            }
        }

        $upit = "SELECT idkorisnik, iduloge, aktivan, neuspjesneprijave 
        FROM korisnik 
        WHERE korisnickoime='".$_POST['korIme']."'";
        $rezultat = $veza->selectDB($upit);
        if ($red = mysqli_fetch_array($rezultat))
        {
            $neuspjesnePrijave = $red['neuspjesneprijave'];
            $neuspjesnePrijave++;
            $upit = "UPDATE korisnik 
            SET neuspjesneprijave='$neuspjesnePrijave'
            WHERE idkorisnik='".$red['idkorisnik']."'";
            $veza->updateDB($upit);
            
            if ($neuspjesnePrijave >= 3)
            {
                $upit = "UPDATE korisnik 
                SET aktivan='0'
                WHERE idkorisnik='".$red['idkorisnik']."'";
                $veza->updateDB($upit);
            }
        }
        $veza->zatvoriDB();
    }
?>
<div class="top-heading">
    <h1>Prijava</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="prijava" method="post" action="">
                <label for="korIme">Korisničko ime: </label>
                <input id="korIme" name="korIme" type="text" placeholder="Korisničko ime" autofocus <?php if(isset($_COOKIE['zapamti'])&&!empty($_COOKIE['zapamti'])) echo "value=\"".$_COOKIE['zapamti']."\""; ?>/>
                <br>
                <label for="lozinka">Lozinka: </label>
                <input id="lozinka" name="lozinka" type="password" placeholder="Lozinka"/>
                <br>
                <label for="zapamti">Zapamti me:</label>
                <input name="zapamti" id="zapamti" type="checkbox"/>
                <br>
                <input name="submit" type="submit" value="Prijava"/>
            </form>
        </div>
    </div>
</div>
<br>
<a href="./registracija.php">Registracija</a>
<br>
<a href="./zaboravljenaLozinka.php">Zaboravljena lozinka</a>

<?php
    require "./podnozje.php";
?>