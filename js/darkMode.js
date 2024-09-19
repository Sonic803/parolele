"use strict";
function changeMode() {
    let element = document.body;
    let mode = document.querySelector("#switchMode").checked

    if (mode) {
        document.cookie = "darkMode=yes;SameSite=Strict;";
    } else {
        document.cookie = "darkMode=no;SameSite=Strict;";
    }
    setMode();
}


function start() {
    setTimeout(function () { document.querySelector("body").classList.add('started'); }, 500);
}

function setMode() {
    let element = document.body;
    let mode = document.cookie.includes("darkMode=yes");

    if (mode) {
        element.classList.add("dark-mode");
        element.classList.remove("light-mode");
        document.querySelector("#switchMode").checked = true;
    } else {
        element.classList.add("light-mode");
        element.classList.remove("dark-mode");
        document.querySelector("#switchMode").checked = false;
    }
}

setMode();