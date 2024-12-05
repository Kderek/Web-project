<?php
    $naslov = "Galerija";
    $potrebnaUloga = 0;
    require "../neregistrirani/zaglavlje.php";

    function ispisGalerije()
    {
        $upit = "SELECT naziv, trajanjepripreme, video, idkategorijejela FROM recept ";
        if (isset($_GET['sortiranje']) && $_GET['sortiranje'] != 0)
        {
            $upit .= "ORDER BY ".$_GET['sortiranje'];
        }
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                if (!isset($_GET['kategorija']) || $_GET['kategorija'] == 0 || $_GET['kategorija']==$red['idkategorijejela'])
                {
                    echo "<iframe width=200 height=200 src=\"".$red['video']."\"></iframe>";
                }
                
            }
        }
        $veza->zatvoriDB();
    }

    function ispisSvihKategorija()
    {
        $upit = "SELECT idkategorijajela, naziv FROM kategorijajela ";
        $veza = new Baza();
        $veza->spojiDB();
        $rezultat = $veza->selectDB($upit);

        while ($red = mysqli_fetch_array($rezultat))
        {
            if ($red)
            {
                echo "<option value=\"".$red['idkategorijajela']."\" ";
                if (isset($_GET['kategorija']) && $_GET['kategorija']==$red['idkategorijajela']) echo "selected";
                echo">".$red['naziv']."</option>";
            }
        }
        $veza->zatvoriDB();
    }
?>
<div class="top-heading">
    <h1>Galerija</h1>
</div>
<div class="features-section">
      <div class="columns-wraper">
        <div class="column">
            <form name="filter" method="get" action="">
                <label form="sortiranje">Sortiranje: </label>
                <select name="sortiranje">
                    <option value="1">Naziv</option>
                    <option value="2" <?php if(isset($_GET['sortiranje']) && $_GET['sortiranje'] == 2) echo "selected"?>>Trajanje pripreme</option>
                </select>
                <label form="kategorija">Kategorija jela: </label>
                <select name="kategorija">
                    <option value="0">Sve kategorije</option>
                    <?php ispisSvihKategorija() ?>
                </select>
                <input type="submit" name="filtriraj" value="Filtriraj"/>
            </form>
            <?php ispisGalerije() ?>
        </div>
    </div>
</div>

<?php
    require "../neregistrirani/podnozje.php";
?>