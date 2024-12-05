<?php
class Dnevnik {
    
    private $nazivDatoteke = "izvorne_datoteke/dnevnik.log";
    
    public function setNazivDatoteke($nazivDatoteke) {
        $this->nazivDatoteke = $nazivDatoteke;
    }
        
    /**
     * Funkcija za dodavanje u dnevnik!
     * @param type $tekst
     * @param type $baza - koristi bazu
     */
    public function spremiDnevnik($tipDnevnika, $radnja=null, $upit=null, $baza=false) {
        if($baza){
            $veza = new Baza();
            $veza->spojiDB();
            if (isset($_SESSION[Sesija::KORISNIK]))
            {
                $upit = "INSERT INTO dnevnik 
                VALUES (DEFAULT, '$radnja', \"$upit\", '".date("Y-m-d H:i:s")."', '".$_SESSION[Sesija::KORISNIK]."', '$tipDnevnika')";
                $veza->updateDB($upit);
            }
            else
            {
                $upit = "INSERT INTO dnevnik 
                VALUES (DEFAULT, '$radnja', \"$upit\", '".date("Y-m-d H:i:s")."', NULL, '$tipDnevnika')";
                $veza->updateDB($upit);
            }
            $veza->zatvoriDB();
        } else {
            $f = fopen($this->nazivDatoteke,"a+");
            fwrite($f, date("d.m.Y H:i:s")." ".$tekst."\n");
            fclose($f);
        }
    }
    
    public function citajDnevnik($baza=false){
        if($baza){
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT * FROM dnevnik";
            $rezultat = $veza->selectDB($upit);
            $veza->zatvoriDB();
            return $rezultat;
        } else {
            return file($this->nazivDatoteke);
        }
    }
}
?>