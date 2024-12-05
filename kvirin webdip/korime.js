var dateTimeErrors = "";
var fileErrors = "";
var descriptionErrors = "";

document.getElementById("obrazac").addEventListener("submit", function (event) {
    var formErrors = "";
    var description = document.getElementById("opis").value;
    var descriptionLength = description.length; //dužina opisa

    if (descriptionLength < 100) {
        descriptionErrors += "\n Opis mora sadržavati minimalno 100 znakova";
    }
    if (document.getElementById("dat").value == "") dateTimeErrors += "\n Potrebno je unijeti datum";
    if (dateTimeErrors != "") formErrors += dateTimeErrors;

    if (fileErrors != "") formErrors += formErrors != "" ? "\n" + fileErrors : fileErrors; //to ti je if u jednom redu ako formErrors već sadrži neki tekst dodaj mu novi red pa sljedeću grešku, a ako je prazan onda samo gršku bez novog reda
    if (descriptionErrors != "") formErrors += formErrors != "" ? "\n" + descriptionErrors : descriptionErrors;

    if (formErrors != "") {
        event.preventDefault();
        alert(formErrors);
        //dodavanje * na labelu i mijenjanje boje teksta ako postoji greška
        if(dateTimeErrors != "") {
          document.getElementById("dat_label").innerHTML = "Datum i vrijeme *";
          document.getElementById("dat_label").classList.add("invalidInput");
        }
        else {
          document.getElementById("dat_label").innerHTML = "Datum i vrijeme";
          document.getElementById("dat_label").classList.remove("invalidInput");
        }
        if(fileErrors != "") {
            document.getElementById("myfile_label").innerHTML = "Naziv datoteke *";
            document.getElementById("myfile_label").classList.add("invalidInput");
        }
        else {
            document.getElementById("myfile_label").innerHTML = "Naziv datoteke";
            document.getElementById("myfile_label").classList.remove("invalidInput");
        }
        if(descriptionErrors != "") {
            document.getElementById("description_label").innerHTML = "Opis *";
            document.getElementById("description_label").classList.add("invalidInput");
        }
        else {
            document.getElementById("description_label").innerHTML = "Opis";
            document.getElementById("description_label").classList.remove("invalidInput");
        }

    }
});

//--START OF COUNTDOWN--//
var countdownElement = document.getElementById("countdown");
function countDown() {
    var countdownElementValue = countdownElement.innerHTML;
    var minutes = parseInt(countdownElementValue.split(":")[0]);
    var seconds = parseInt(countdownElementValue.split(":")[1]);

    if (seconds == 59) { //provjera je li prošlo 59 sekundi - ako je onda sekunde postavlja na 0 i povećava minute za 1, u suprotnom povećava sekunde za 1
        seconds = 0;
        minutes += 1;
    }
    else seconds += 1;

    if (minutes == 10) { //ako je prošlo 10 minuta postavlja sekunde i minute na 0 i resetira formu
        seconds = 0;
        minutes = 0;
        document.getElementById("obrazac").reset();
    }
    if (seconds < 10) seconds = "0" + seconds; // ako je jednoznamenkasti broj dodaje 0 ispred
    if (minutes < 10) minutes = "0" + minutes; // ako je jednoznamenkasti broj dodaje 0 ispred

    countdownElement.innerHTML = minutes + ":" + seconds;
}

setInterval(countDown, 1000); //pozivanje funkcije svaku sekundu
//--END OF COUNTDOWN--//

//--START OF DATETIME VALIDATION--//

document.getElementById("dat").addEventListener("keyup", dateTimeValidation);
function dateTimeValidation() {
    dateTimeErrors = "";
    if (document.getElementById("dat").getAttribute('type') !== "text") dateTimeErrors += "Datum nije tipa tekst"; //provjera jel element tipa text
    var isDateTimeValid = true;
    var dateTime = document.getElementById("dat").value;
    var dateSplitIntoDateAndTime = dateTime.split(" "); //splita datumVrijeme po razmaku da bi dobili odvojeno datum i vrijeme
    if (dateSplitIntoDateAndTime.length !== 2) { //kad se nešto splita to se dobije u polju N elemenata, u ovom slučaju to polje treba sadržavat dva elementa (datum i vrijeme). Provjera ako ne sadrži dva elementa da uopće ne ide dalje provjeravat ispravnost formata nego se returna
        isDateTimeValid = false;
        document.getElementById("dat_label").innerHTML = "Datum i vrijeme kreiranja *";
        document.getElementById("dat_label").classList.add("invalidInput");
        return;
    }
    var date = dateSplitIntoDateAndTime[0];
    var time = dateSplitIntoDateAndTime[1];

    if (!checkIfDateIsInGoodFormat(date)) {
        isDateTimeValid = false;
    }
    if (!checkIfTimeIsInGoodFormat(time)) {
        isDateTimeValid = false;
    }
    if (!isDateTimeValid) { //ako je varijabla false
        document.getElementById("dat_label").innerHTML = "Datum i vrijeme kreiranja *";
        document.getElementById("dat_label").classList.add("invalidInput"); //ako je neispravan format dodaje mmu se ta css klasa koja postavlja boju labele u crvenu

        dateTimeErrors = "\n Neispravan format datuma";
    }
    else {
        document.getElementById("dat_label").innerHTML = "Datum i vrijeme kreiranja";
        document.getElementById("dat_label").classList.remove("invalidInput"); //ako je ispravno remova se klasa i labla više nije crvena
    }
  }

function checkIfDateIsInGoodFormat(date) {
    var splitDate = date.split(".");//splita po točki da bi dobili odvojeno dan, mjesec i godinu
    if (splitDate.length !== 4 || checkNumberOfDots(date) !== 3) { //provjera ako ima razlicito od 4 elementa zato što mora imat dan, mjesec i godinu + još prazan string jer i nakon godine ide "." i u polju ces imat 4 elementa (npr. ['09', '06', '2022', '']). i provjera da ima ukupno tri točke u tom cijelom stringu
        return false;
    }
    var day = splitDate[0];
    var month = splitDate[1];
    var year = splitDate[2];
    var ifDaysAreInRange = day >= 1 && day <= 31 ? true : false; //varijabla će bit false ako je dan manji od 1 i veći od 31
    var ifMonthsAreInRange = month >= 1 && month <= 12 ? true : false; //varijabla će biti false ako je mjesec manji od 1 i veći od 12

    if (!ifDaysAreInRange || !ifMonthsAreInRange) {
        return false;
    }
    if (day.length !== 2 || month.length !== 2 || year.length !== 4) { //provjera je li dan i mjesec sadrže 2 znamenke i godina 4
        return false;
    }
    return true;
}
function checkIfTimeIsInGoodFormat(time) {
    var splitTime = time.split(":");
    if (splitTime.length !== 3) { //provjera jel polje za vrijeme sadrži 3 elementa jer je splitano po ":" i trebalo bi sadržavat sate, minute i sekunde (npr. ['12', '12', '12']
        return false;
    }
    var hours = splitTime[0];
    var minutes = splitTime[1];
    var seconds = splitTime[2];
    var ifHoursAreInRange = hours >= 0 && hours <= 23 ? true : false; //varijabla će bit false ako su sati manji od 0 i veći od 23
    var ifMinutesAreInRange = minutes >= 0 && minutes <= 59 ? true : false; //varijabla će bit false ako su minute manji od 0 i veći od 59
    var ifSecondsAreInRange = seconds >= 0 && seconds <= 59 ? true : false; //varijabla će bit false ako su sekunde manje od 0 i veći od 59
    if (!ifHoursAreInRange || !ifMinutesAreInRange || !ifSecondsAreInRange) {
        return false;
    }
    if (hours.length !== 2 || minutes.length !== 2 || seconds.length !== 2) {
        return false;
    }
    return true;
}
function checkNumberOfDots(date) {
    return date.split(".").length - 1;
}
//--END OF DATETIME VALIDATION--//

//--START OF FILE VALIDATION--//
document.getElementById("myfile").addEventListener("change", checkFile);

function checkFile() {
    fileErrors = "";
    var file = document.getElementById("myfile");
    var fileExtension = file.value.substr(-3); //uzima zadnja 3 znaka iz naziva fajla i tako dobijemo ekstenziju
    var fileSize = file.files[0].size / 1000000; //veličina fajla pretvorena u MB

    if (fileExtension != "pdf" && fileExtension != "png" && fileExtension != "jpg" && fileExtension != "mp3" && fileExtension != "mp4") {
        file.value = null;
        fileErrors += "\n Neispravna ekstenzija datoteke";
    }
    if (fileSize > 1) {
        file.value = null;
        fileErrors += "\n Datoteka ne smije biti veća od 1MB";
    }
}
//--END OF FILE VALIDATION--//


//--START OF TEXTAREA VALIDATION--//
document.getElementById("opis").addEventListener("focusout", checkDescription);

function checkDescription() {
    descriptionErrors = "";
    var description = document.getElementById("opis").value;
    var numberOfErrors = 0;
    var descriptionLength = description.length; //dužina opisa

    if (descriptionLength < 100) {
        numberOfErrors += 1;
        descriptionErrors += "\n Opis mora sadržavati minimalno 100 znakova";
    }

    //Provjerava je li opis ima nedozvoljenih znakova
    if (description.includes('"')) {
        numberOfErrors += numberOfNotAllowedChars(description, '"');
        descriptionErrors += "\n Opis ne smije sadržavati znak" + ' "';
    }
    if (description.includes("'")) {
        numberOfErrors += numberOfNotAllowedChars(description, "'");
        descriptionErrors += "\n Opis ne smije sadržavati znak '";
    }
    if (description.includes("<")) {
        numberOfErrors += numberOfNotAllowedChars(description, "<");
        descriptionErrors += "\n Opis ne smije sadržavati znak <";
    }
    if (description.includes(">")) {
        numberOfErrors += numberOfNotAllowedChars(description, ">");
        descriptionErrors += "\n Opis ne smije sadržavati znak >";
    }
    if (description.includes("..")) {
        numberOfErrors += numberOfNotAllowedChars(description, "..");
        descriptionErrors += "\n Opis ne smije sadržavati dvije točke uzastopno";
    }
    if (numberOfErrors) alert("Broj grešaka u opisu: " + numberOfErrors);

}

function numberOfNotAllowedChars(description, char) { // broji koliko je nedozvoljenih znakova u opisu
    return description.split(char).length - 1;
}
//--END OF TEXTAREA VALIDATION--//
