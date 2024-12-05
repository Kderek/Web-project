<?php
    $naslov = "Registracija";
    $potrebnaUloga = 0;
    require "./zaglavlje.php";
    $greske = "";

    function generirajAktivacijskiKod()
    {
        $znakovi = "0123456789abcdefghijklmnopqrstuvwxyz";
        $aktivacijskiKod = "";
        for ($i = 0; $i < 10; $i++) {
            $aktivacijskiKod .= $znakovi[rand(0, strlen($znakovi) - 1)];
        }
        return $aktivacijskiKod;
    }

    if (isset($_POST['submit']))
    {
        if (empty($_POST['email']) || empty($_POST['korime']) || empty($_POST['lozinka']) || empty($_POST['ponovljenalozinka']) || empty($_POST['ime']) || empty($_POST['prezime']))
        {
            $greske .= "Nisu unesena sva polja!<br>";
        }
        else if ($_POST['lozinka'] != $_POST['ponovljenalozinka'])
        {
            $greske .= "Lozinke se ne podudaraju!<br>";
        }
        else if (strlen($_POST['korime']) < 3)
        {
            $greske .= "Korisničko ime mora imati barem 3 znaka!<br>";
        }
        else if (!preg_match('/^([A-Z]|[a-z]|[0-9]){1}([a-z]|[A-Z]|[0-9]|(\.))*@(([a-z]|[A-Z])+)\.(([a-z]|[A-Z])+)$/', $_POST['email']))
        {
            $greske .= "E-mail nije ispravnog formata!<br>";
        }
        else
        {
            $sha = hash("sha256", $_POST['lozinka']);
            $datum = date("Y-m-d H:i:s");
            $aktivacijskiKod = generirajAktivacijskiKod();
            $upit = "INSERT INTO korisnik 
            VALUES (DEFAULT, '".$_POST['email']."', '".$_POST['korime']."', '".$_POST['lozinka']."', '$sha', '".$_POST['ime']."', '".$_POST['prezime']."', '$datum', '0', '1', '0', '$aktivacijskiKod')";
            $veza = new Baza();
            $veza->spojiDB();
            $rezultat = $veza->updateDB($upit);
            $veza->zatvoriDB();
            $dnevnik->spremiDnevnik(2, "Registracija", $upit, true);
            $link = str_replace("registracija.php", "aktivacija.php", $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]) . "?korime=".$_POST['korime']."&kod=$aktivacijskiKod";
            echo $link;
            //mail($_POST['email'], "Aktivacija računa", "Link za aktivaciju: $link");
            //header("Location: prijava.php");
        }
    }
?>
<div class="top-heading">
    <h1>Registracija</h1>
</div>
<script src="./validacija.js"></script>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <a><?php echo $greske; ?></a>
            <form name="registracija" method="post" action="">
                <label for="email">E-mail: </label>
                <input id="email" name="email" type="text" placeholder="E-mail" autofocus/>
                <br>    
                <label for="korime">Korisničko ime: </label>
                <input id="korime" name="korime" type="text" placeholder="Korisničko ime" autofocus/>
                <br>
                <label for="lozinka">Lozinka: </label>
                <input id="lozinka" name="lozinka" type="password" placeholder="Lozinka"/>
                <br>
                <label for="ponovljenalozinka">Ponovljena lozinka: </label>
                <input id="ponovljenalozinka" name="ponovljenalozinka" type="password" placeholder="Ponovljena lozinka"/>
                <br>
                <label for="ime">Ime: </label>
                <input id="ime" name="ime" type="text" placeholder="Ime" autofocus/>
                <br>
                <label for="prezime">Prezime: </label>
                <input id="prezime" name="prezime" type="text" placeholder="Prezime" autofocus/>
                <br>
                <input id="submit" name="submit" type="submit" value="Registracija"/>
            </form>
        </div>
    </div>
</div>

<?php
    require "./podnozje.php";
?>