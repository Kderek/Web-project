<?php
    $naslov = "Početna stranica";
    $potrebnaUloga = 0;
    require "../neregistrirani/zaglavlje.php";

    function ispisKorisnika($idKorisnika)
    {
        $upit = "SELECT ime, prezime 
        FROM korisnik
        WHERE idkorisnik='$idKorisnika'";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        if ($red = mysqli_fetch_array($rezultat))
        {
            $veza->zatvoriDB();
            return $red['ime']." ".$red['prezime'];
        }
        $veza->zatvoriDB();
        return "";
    }

    function ispisRankListe()
    {
        $upit = "SELECT AVG(p.ocjena) as prosjek, p.idkorisnika, t.zavrsetak
        FROM prijava p
        LEFT JOIN tecaj t 
        ON p.idtecaja=t.idtecaj ";
        if (isset($_GET['od']) && !empty($_GET['od']))
        {
            $od = date("Y-m-d H:i:s", strtotime($_GET['od']));
            $upit .= "WHERE t.zavrsetak > '$od'";
            if (isset($_GET['do']) && !empty($_GET['do']))
            {
                $do = date("Y-m-d H:i:s", strtotime($_GET['do']));
                $upit .= " AND t.zavrsetak < '$do'";
            }
        }
        else if (isset($_GET['do']) && !empty($_GET['do']))
        {
            $do = date("Y-m-d H:i:s", strtotime($_GET['do']));
            $upit .= "WHERE t.zavrsetak < '$do'";
        }
        $upit .= "GROUP BY p.idkorisnika 
        ORDER BY prosjek DESC";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        $i = 1;
        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                if (!isset($_GET['od']) || empty($_GET['od']) || strtotime($_GET['od']) < strtotime($red['zavrsetak']))
                {
                    if (!isset($_GET['do']) || empty($_GET['do']) || strtotime($_GET['do']) > strtotime($red['zavrsetak']))
                    {

                        echo "<tr>
                            <td>$i</td>
                            <td>".ispisKorisnika($red['idkorisnika'])."</td>
                            <td>".$red['prosjek']."</td>
                            </tr>";
                        
                    }
                }
            }
            $i++;
        }
        $veza->zatvoriDB();
    }
?>

<div class="top-heading">
    <h1>Rank lista korisnika</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="filter" method="get" action="">
                <label for="od">Od: </label>
                <input name="od" type="datetime-local" <?php if(isset($_GET['od']) && !empty($_GET['od'])) echo "value=\"".$_GET['od']."\"" ?>/>
                <label for="do">Do: </label>
                <input name="do" type="datetime-local" <?php if(isset($_GET['do']) && !empty($_GET['do'])) echo "value=\"".$_GET['do']."\"" ?>/>
                <input type="submit" name="filtriraj" value="Filtriraj"/>
            </form>
            <table border="1">
                <tr>
                    <th>Rank</th>
                    <th>Korisnik</th>
                    <th>Prosječna ocjena</th>
                </tr>
                <?php ispisRankListe(); ?>
            </table>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>