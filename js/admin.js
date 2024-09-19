"use strict";
function error(errore) {
    console.error(errore);
}

function resetDay() {
    let data = new FormData();
    data.set('reset', 'true');

    fetch_php(data, '../php/admin.php', function (data) {
        console.log('Success:', data["newWord"]);
        paroladelgiorno();
    }, error);

}

function paroladelgiorno() {
    let data = new FormData();
    data.set('check', 'true');

    fetch_php(data, '../php/admin.php', function (data) {
        document.querySelector(".wordOfTheDay").childNodes[2].textContent = data["word"];
    }, error);
}