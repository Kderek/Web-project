<?php
    $naslov = "Moderatori kategorije";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    if (!isset($_GET['id']))
        header("Location: ./kategorijeJela.php");
    
    $nazivKategorije = "";
    $upit = "SELECT naziv
    FROM kategorijajela 
    WHERE idkategorijajela='".$_GET['id']."'";
    $veza = new Baza();
    $veza->spojiDB();
    $rezultat = $veza->selectDB($upit);
    if ($red = mysqli_fetch_array($rezultat))
    {
        $nazivKategorije = $red['naziv'];
    }
    $veza->zatvoriDB();

    function ispisAktivniModeratori()
    {
        $upit = "SELECT idkorisnik, email, korisnickoime, ime, prezime 
        FROM moderira m
        LEFT JOIN korisnik k
        ON m.idkorisnika=k.idkorisnik
        WHERE m.idkategorijejela='".$_GET['id']."'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                    <td>".$red['email']."</td>
                    <td>".$red['korisnickoime']."</td>
                    <td>".$red['ime']."</td>
                    <td>".$red['prezime']."</td>
                    <td><a href=\"./ukloniModeratora.php?kategorija=".$_GET['id']."&mod=".$red['idkorisnik']."\">Ukloni</a></td>
                </tr>";
            }
        }
    }

    function ispisNeaktivniModeratori()
    {
        $upit = "SELECT idkorisnik, email, korisnickoime, ime, prezime 
        FROM korisnik k
        WHERE iduloge>='2'
        AND NOT EXISTS 
        (SELECT * 
        FROM moderira m
        WHERE m.idkorisnika=k.idkorisnik
        AND m.idkategorijejela='".$_GET['id']."')";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);
        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<tr>
                    <td>".$red['email']."</td>
                    <td>".$red['korisnickoime']."</td>
                    <td>".$red['ime']."</td>
                    <td>".$red['prezime']."</td>
                    <td><a href=\"./dodajModeratora.php?kategorija=".$_GET['id']."&mod=".$red['idkorisnik']."\">Dodaj</a></td>
                </tr>";
            }
        }
    }
?>

<div class="top-heading">
    <h1><?php echo $nazivKategorije ?></h1>
</div>

<div class="bottom-heading">
    <h3>Aktivni moderatori</h3>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <table border=1>
                <tr>
                    <th>E-mail</th>
                    <th>Korisnicko ime</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                </tr>
                <?php ispisAktivniModeratori(); ?>
            </table>
        </div>
    </div>
</div>

<div class="bottom-heading">
    <h3>Nekativni moderatori</h3>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <table border=1>
                <tr>
                    <th>E-mail</th>
                    <th>Korisnicko ime</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                </tr>
                <?php ispisNeaktivniModeratori(); ?>
            </table>
        </div>
    </div>
</div>
<?php
    require "../neregistrirani/podnozje.php";
?>