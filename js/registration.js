"use strict";
const formLogin = document.getElementById("login");
const formRegister = document.getElementById("register");

formLogin.onsubmit = login;
formRegister.onsubmit = register;

async function sha256(message) {
    const msgBuffer = new TextEncoder().encode(message);
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}

function error(message, querySelector) {
    const errorMessage = document.querySelector(querySelector);
    errorMessage.classList.remove("hidden");
    errorMessage.textContent = message;
}

async function login(event) {
    event.preventDefault();
    const querySelector = ".login.error";


    const [username, password] = formLogin.getElementsByTagName('input');
    if (username.value.length == 0) {
        error("Username is empty", ".login.error");
        return;
    }
    if (password.value.length == 0) {
        error("Password is empty", ".login.error");
        return;
    }

    let data = new FormData();
    data.set('username', username.value);
    data.set('hash', await sha256(password.value + username.value));


    fetch_php(data, '../php/login.php', function (data) {
        if (data["login"] === true) {
            window.location.href = "../html/game.php";
        } else {
            console.log(data);
            error(data['error'], querySelector);
        }
    }, function (error) {
        console.error('Error:', error);
    });

}

async function register(event) {

    event.preventDefault();

    const [username, password, confirm] = formRegister.getElementsByTagName('input');
    const querySelector = ".register.error";
    if (password.value != confirm.value) {
        error("Passwords don't match", querySelector);
        return;
    }
    if (username.value.length < 5) {
        error("Username too short", querySelector);
        return;
    }
    if (username.value.length > 20) {
        error("Username too long", querySelector);
        return;
    }
    if (!username.value.match(/^[a-zA-Z0-9]+$/)) {
        error("Username contains invalid characters", querySelector);
        return;
    }
    if (password.value.length < 5) {
        error("Password too short", querySelector);
        return;
    }
    if (password.value.length > 32) {
        error("Password too long", querySelector);
        return;
    }
    if (!password.value.match(/^[a-zA-Z0-9]+$/)) {
        error("Password contains invalid characters", querySelector);
        return;
    }

    let data = new FormData();
    data.set('username', username.value);
    data.set('hash', await sha256(password.value + username.value));

    fetch_php(data, '../php/register.php', function (data) {

        if (data["register"] === true) {
            window.location.href = "../html/game.php";
        } else {
            console.log(data);
            error(data['error'], querySelector);

        }
    }, function (error) {
        console.log(error);
        error(data['error'], querySelector);
    });

}