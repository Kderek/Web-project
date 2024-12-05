<?php
    $naslov = "Dnevnik";
    $potrebnaUloga = 3;
    require "../neregistrirani/zaglavlje.php";

    function ispisKorisnika($idKorisnika)
    {
        $upit = "SELECT korisnickoime 
        FROM korisnik
        WHERE idkorisnik='$idKorisnika'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        if ($red = mysqli_fetch_array($rezultat))
        {
            $veza->zatvoriDB();
            return $red['korisnickoime'];
        }
        $veza->zatvoriDB();
        return "";
    }

    function ispisTipaDnevnika($idTipaDnevnika)
    {
        $upit = "SELECT tip 
        FROM tipdnevnika
        WHERE idtipdnevnika ='$idTipaDnevnika'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        if ($red = mysqli_fetch_array($rezultat))
        {
            $veza->zatvoriDB();
            return $red['tip'];
        }
        $veza->zatvoriDB();
        return "";
    }

    function ispisDnevnika()
    {
        $upit = "SELECT radnja, upit, vrijeme, idkorisnika, idtipadnevnika FROM dnevnik";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                if (!isset($_GET['od']) || empty($_GET['od']) || strtotime($_GET['od']) < strtotime($red['vrijeme']))
                {
                    if (!isset($_GET['do']) || empty($_GET['do']) || strtotime($_GET['do']) > strtotime($red['vrijeme']))
                    {
                        if (!isset($_GET['korisnik']) || $_GET['korisnik'] == 0 || $_GET['korisnik'] == $red['idkorisnika'])
                        {
                            echo "<tr>
                            <td>".$red['radnja']."</td>
                            <td>".$red['upit']."</td>
                            <td>".$red['vrijeme']."</td>
                            <td>".ispisKorisnika($red['idkorisnika'])."</td>
                            <td>".ispisTipaDnevnika($red['idtipadnevnika'])."</td>
                            </tr>";
                        }
                    }
                }
            }
        }
        $veza->zatvoriDB();
    }
    
    function ispisSvihKorisnika()
    {
        $upit = "SELECT idkorisnik, korisnickoime FROM korisnik ";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<option value=\"".$red['idkorisnik']."\" ";
                if (isset($_GET['korisnik']) && $_GET['korisnik']==$red['idkorisnik']) echo "selected";
                echo">".$red['korisnickoime']."</option>";
            }
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Dnevnik</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="filter" method="get" action="">
                <label for="od">Od: </label>
                <input name="od" type="datetime-local" <?php if(isset($_GET['od']) && !empty($_GET['od'])) echo "value=\"".$_GET['od']."\"" ?>/>
                <label for="do">Do: </label>
                <input name="do" type="datetime-local" <?php if(isset($_GET['do']) && !empty($_GET['do'])) echo "value=\"".$_GET['do']."\"" ?>/>
                <label form="korisnik">Korisnik: </label>
                <select name="korisnik">
                    <option value="0">Svi korisnici</option>
                    <?php ispisSvihKorisnika(); ?>
                </select>
                <input type="submit" name="filtriraj" value="Filtriraj"/>
            </form>
            <table border=1>
                <tr>
                    <th>Radnja</th>
                    <th>Upit</th>
                    <th>Vrijeme</th>
                    <th>Korisnik</th>
                    <th>Tip radnje</th>
                </tr>
                <?php ispisDnevnika(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>