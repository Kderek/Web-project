var emailTocan = true;
var korisnickoImeTocan = true;
var lozinkaTocan = true;
var imeTocan = true;
var prezimeTocan = true;
document.addEventListener("DOMContentLoaded", function(){

    document.getElementById("email").addEventListener("change", provjeriEmail());
    document.getElementById("korime").addEventListener("change", provjeriKorisnickoIme());
    document.getElementById("lozinka").addEventListener("change", provjeriLozinku());
    document.getElementById("ponovljenalozinka").addEventListener("change", provjeriLozinku());
    document.getElementById("ime").addEventListener("change", provjeriIme());
    document.getElementById("prezime").addEventListener("change", provjeriPrezime());

    document.getElementById("submit").addEventListener("click", function(event){
        var greske = "";
        provjeriEmail();
        if (!emailTocan)
        {
            greske += "Neispravan email\n";
        }
        provjeriKorisnickoIme();
        if (!korisnickoImeTocan)
        {
            greske += "Neispravno korisničko ime\n";
        }
        provjeriLozinku();
        if (!lozinkaTocan)
        {
            greske += "Neispravne lozinke\n";
        }
        provjeriIme();
        if (!imeTocan)
        {
            greske += "Neispravno ime\n";
        }
        provjeriPrezime();
        if (!prezimeTocan)
        {
            greske += "Neispravno prezime\n";
        }

        if (!emailTocan || !korisnickoImeTocan || !lozinkaTocan || !imeTocan || !prezimeTocan)
        {
            event.preventDefault();
            window.alert(greske);
        }
    });
});

function provjeriEmail()
{
    emailTocan = true;
    var regex = /^([A-Z]|[a-z]|[0-9]){1}([a-z]|[A-Z]|[0-9]|(\.))*@(([a-z]|[A-Z])+)\.(([a-z]|[A-Z])+)$/;
    if (document.getElementById("email").value == "")
    {
        emailTocan = false;
    }
    else if (!regex.test(document.getElementById("email").value))
    {
        emailTocan = false;
    }
}
function provjeriKorisnickoIme()
{
    korisnickoImeTocan = true;
    if (document.getElementById("korime").value == "")
    {
        korisnickoImeTocan = false;
    }
    else if (document.getElementById("korime").value.length < 3)
    {
        korisnickoImeTocan = false;
    }
}
function provjeriLozinku()
{
    lozinkaTocan = true;
    if (document.getElementById("lozinka").value == "")
    {
        lozinkaTocan = false;
    }
    else
    {
        if (document.getElementById("ponovljenalozinka").value == "")
        {
            lozinkaTocan = false;
        }
        else if (document.getElementById("lozinka").value != document.getElementById("ponovljenalozinka").value)
        {
            lozinkaTocan = false;
        }
    }
}
function provjeriIme()
{
    imeTocan = true;
    if (document.getElementById("ime").value == "")
    {
        imeTocan = false;
    }
}
function provjeriPrezime()
{
    prezimeTocan = true;
    if (document.getElementById("prezime").value == "")
    {
        prezimeTocan = false;
    }
}