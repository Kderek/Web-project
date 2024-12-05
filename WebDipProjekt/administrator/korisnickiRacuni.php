<?php
    $naslov = "Korisnički računi";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    function ispisUloge($idUloge)
    {
        $upit = "SELECT naziv 
        FROM uloga
        WHERE iduloga='$idUloge'";
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

    function ispisKorisnika()
    {
        $upit = "SELECT idkorisnik, email, korisnickoime, ime, prezime, iduloge, aktivan 
        FROM korisnik";
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
                <td>".ispisUloge($red['iduloge'])."</td>
                <td>";
                if ($red['aktivan'] == 1) echo "Aktivan";
                else echo "Neaktivan";
                echo "</td>
                <td><a href=\"promjeniStatusKorisnika.php?id=".$red['idkorisnik']."&status=".$red['aktivan']."\">";
                if ($red['aktivan'] == 1) echo "Deaktiviraj";
                else echo "Aktiviraj";
                echo "</a></td>
                </tr>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Korisnički računi</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <table border=1>
                <tr>
                    <th>Email</th>
                    <th>Korisničko ime</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Uloga</th>
                    <th>Status</th>
                </tr>
                <?php ispisKorisnika(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>