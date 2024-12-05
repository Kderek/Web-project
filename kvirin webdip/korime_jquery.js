//--START OF MULTIMEDIJA--//
//OVO ODKOMENTIRAT KAD STAVIS NA SERVER, LOKALNO NE RADI
//var searchValues = new Array();
// $.ajax({
//     url: "search.json",
//     type: "GET",
//     dataType: "json",
//     success: function (data) {
//         $.each(data, function (key, val) {
//             searchValues.push(val); //dohvaćanje podataka ajaxom pomocu GET metode iz search.json i pushanje u array koji postavljas dolje u search komponentu
//         });
//     }, error: function (data) {
//         alert("Error:" + data);
//     }
// });
var searchValues = ["Naslov", "Gaming", "Highlights", "Review", "Novo", "Svijetu", "PC", "Pametne", "Spravice", "Corsair", "Komponenti"]; //OVO MAKNI KAD STAVIS NA SERVER
$("#search").autocomplete({ source: searchValues });
$("#search_button").click(function () {
    var searchValue = $("#search").val(); //vrijednost koji si odabrao za pretraživanje
    if (searchValue) { //ako je odabrana riječ za pretraživanje
        var elements = $(".searchByTitle"); //klasa koja je dodana svakom naslovu (h1), dohvaćanje svih elemenata koji imaju tu klasu
        var foundElementsWithSearchValue = 0; //pomoću ove varijable ćemo pratit jel pronađen ijedan video s tim tekstom i ako ta vrijednost bude nula na kraju nakon for petlje ispisivat ce se "nema podataka"

        for (var i = 0; i < elements.length; i++) { //prolazimo kroz sve h1 naslove (samo ove za video i audio)
            var currentElement = $(elements[i]); // trenutni h1 element
            var currentElementTitle = currentElement.text(); //tekst trenutnog naslova
            var parentElement = currentElement.parent(); //parent element od h1 - a to će ti uvijek biti video ili audio - u htmlu sam svakom dodala klasu svakom videu i audio zasebno (iako bi bilo bolje da je id jer je uvijek samo jedan element, al smrda se onda css a po tom mi se ne da prčkat :D)
            if (currentElementTitle.includes(searchValue)) { //tu provjeravamo jel trenutni naslov sadrži tekst koji smo odabrali za pretraživanje
                parentElement.css("display", "grid"); //ako sadrži dodajemo mu ovaj css property koji mu služi da se prikaže i povećavamo varijeblu ispod za 1 da ne bi prikazivali "Nema podataka"
                foundElementsWithSearchValue += 1;
            }
            else parentElement.css("display", "none"); // tu ga skrivamo - moguće da će te pitat zasto si koristio css property "display" a ne "visible", reci da kad ga pomoću visible skrivas/prikazujes on i dalje zauzima mjesto samo nije vidljiv, a pomocu display: none ne zauzuma mjesto. Možeš probat zamijenit display sa visible pa ćeš vidjet sta se događa. Npr ako napises "Naslov" ovi videi ce se prije sakrit, al će zauzimat prostor pa moraš skrolat dolje do audia
        }
        if (foundElementsWithSearchValue == 0) $("#noDataText").css("display", "block"); //prikaz "Nema podataka"
        else $("#noDataText").css("display", "none");
    }
    else alert("Odaberite vrijednost za pretraživanje"); //ako ništa nije napisano za pretraživanje da ne ide bezveze odrađivat sve ovo u if-u
});
//--END OF MULTIMEDIJA--//

if (location.href.includes("popis.html")) { //ako se trenutno nalazi na stranici popis.html
    var tableData = new Array();
    $.ajax({
        url: "https://barka.foi.hr/WebDiP/2021/materijali/zadace/dz3/userNameSurname.php?all",
        type: "POST",
        dataType: "xml",
        success: function (response) {
            $(response).find("user").each(function () { //šibni u ovaj servis u chrome i vidjet ces u kojem se obliku vrati, i sad pomocu funkcije .find("user") nađe sve usere i pomoću .each() funkcije prolazi kroz jednog po jednog
                //this je trenutni user
                tableData.push( //u ovo polje pushamo podatke o userima koji nam trebaju, i to ce nam kasnije bit source za tablicu 
                    {
                        userId: this.id != "" ? this.id : "Podatak ne postoji", //dohvacas id
                        userType: $(this).attr("tip") ? $(this).attr("tip") : "Podatak ne postoji", //<user status="nesto" tip="nesto"> i to su atributi od "user" i zato njih dohvacas pomocu .attr() funkcije 
                        userStatus: $(this).attr("status") ? $(this).attr("status") : "Podatak ne postoji", //oni se nalaze bas unutar usera <user> tu se nalaze </user> i dohvacas ih na ovaj nacin, znaci pomocu find() funkcije nađeš što ti treba i to ti dohvati cijeli element i pomocu text() funkcije doiješ tekst koji se nalazi unutar elementa
                        userUsername: $(this).find("username").text() ? $(this).find("username").text() : "Podatak ne postoji",
                        userBlockedUntil: $(this).find("blocked_until").text() ? $(this).find("blocked_until").text() : "Podatak ne postoji",
                        userFailedLogin: $(this).find("failed_login").text() ? $(this).find("failed_login").text() : "Podatak ne postoji",
                        userSurname: $(this).find("surname").text(),
                        userName: $(this).find("name").text(),
                        userPassword: $(this).find("password").text(),
                        userEmail: $(this).find("email").text()
                    }
                );
            });

            $('#table').DataTable({ //ovaj DataTable ti je jquery biblioteka koju smo incudali u popis.html na dnu, jedan .js fajl i jedan .css fajl
                data: tableData, //daješ data source tablici, znaci podaci koji ce se prikazivat
                lengthChange: false, //stavi na true pa ces vidjet sta ce ti se pojavit iznad tablice, to ne piše da mora imat pa sam stavila na false
                columns: [ //definirnanje stupaca
                    { className: "userId", data: "userId", title: 'ID korisnika' }, // tu smo dodali klasu da možemo ulovit klik na id
                    { data: "userUsername", title: 'Korisničko ime' },
                    { data: "userType", title: 'Tip' },
                    { data: "userStatus", title: 'Status' },
                    { data: "userFailedLogin", title: 'Neuspješne prijave' },
                    { data: "userBlockedUntil", title: 'Datum i vrijeme blokiranja' }
                ],
                language: { //ptijevod komponenti na tablici, probaj zakomentirat pa ćeš vidjet da će sve bit na eng
                    "sSearch": "Pretraži",
                    "sInfo": "Prikazano _START_ do _END_ od ukupno _TOTAL_ zapisa",
                    "oPaginate": {
                        "sPrevious": "Prethodni",
                        "sNext": "Sljedeći",
                    },
                }
            });

        }, error: function (data) {
            alert("Error:" + data);
        }
    });
}
$('#table').on("click", "td.userId", function () { //klik na id
    var id = this.textContent; //vrijednost id-a
    var currentlySelectedUser = tableData.filter(function (item) { //filtriramo kroz sve usere iz tablice
        return item.userId == id; //želimo potrefit samo ovog usera čiji id je kliknut i onda se u varijablu currentlySelectedUser(koja je polje jer filter() funkcija uvijek vraća polje) spremamo te podatke
    });

    var userData = { //objekt sa podacima o kliknutom useru
        id: id,
        username: currentlySelectedUser[0].userUsername,
        surname: currentlySelectedUser[0].userSurname,
        name: currentlySelectedUser[0].userName,
        password: currentlySelectedUser[0].userPassword,
        email: currentlySelectedUser[0].userEmail
    };

    $.cookie(id, JSON.stringify(userData), { path: '/' }); //dodajemo cookie čiji je key id korisnika i vrijednosti su ovaj objekt koji je pretvoren u string(JSON.stringfy()) jer koliko znam cookie ne prima objekt ko vrijednost
    location.href = "obrasci/registracija.html"; //prebacujemo se na stranicu registracija
})
//--END OF POPIS--//
