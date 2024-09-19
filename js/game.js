"use strict";
const alphabet = 'abcdefghijklmnopqrstuvwxyz';

// Returns the position of a letter in the alphabet (-1 if not found)
function getLetterPosition(letter) {
    let position = alphabet.indexOf(letter.toLowerCase());
    return position;
}

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}

let srcs = ["../mp3/0.wav", "../mp3/1.wav", "../mp3/2.wav", "../mp3/back.wav"];
let audioArray = [];

for (let i = 0; i < srcs.length; i++) {
    audioArray[i] = new Audio(srcs[i]);
}

function spawnSound(src) {
    let audio = audioArray[src].cloneNode();
    audio.play();
    audio.onended = function () {
        audio.remove();
    }
}

let conta = 0;

function sound(a) {
    let src;
    if (a == "quiet") {
        src = conta;
        conta = (conta + 1) % 2;
    } else {
        src = 3
    }
    spawnSound(src);

}



class tabella {
    constructor(query) {
        this.board = document.querySelector(query);
        this.board.innerHTML = '';
        for (let i = 0; i < 6; i++) {
            let row = document.createElement('tr');
            row.className = 'riga';
            for (let j = 0; j < 5; j++) {
                let cell = document.createElement('td');
                cell.className = 'cella';
                row.appendChild(cell);
            }
            this.board.appendChild(row);
        }

        this.celle = document.querySelectorAll('.cella');
        this.position = 0;
        this.lastSent = 0;
        this.word = '';
        this.querySelector = ".game.error";
        this.end = false;
        this.refresh();
        this.keyboard = new keyboard();
    }

    error(message, querySelector) {
        if (message == '' || message == undefined)
            message = "Something went wrong...";
        const errorMessage = document.querySelector(querySelector);
        errorMessage.classList.remove('hidden');
        errorMessage.textContent = message;
    }

    onError(error) {
        console.error('Error:', error);
        this.error("Something went wrong...", this.querySelector);
    }

    setClass(cella, classe) {
        cella.classList.remove('scritto');
        cella.classList.remove('cancellato');
        cella.classList.remove('cancellatoVeloce');
        cella.classList.remove('nonesiste');
        cella.classList.remove('esiste');
        //This way the animation is played even if the class is already present
        setTimeout(function () { cella.classList.add(classe); }.bind(cella), 10);
    }

    letter(letter) {
        if (this.position == this.lastSent + 5 || this.end) {
            return 0;
        }
        this.celle[this.position].innerHTML = alphabet[letter];
        this.setClass(this.celle[this.position], 'scritto');
        this.word += alphabet[letter];
        this.position++;
        return 1;
    }

    backspace(isFive) {
        if (this.position == this.lastSent || this.end) {
            return 0;
        }
        this.position--;
        this.celle[this.position].innerHTML = '';
        this.celle[this.position].classList.remove('scritto');
        if (isFive == 1)
            this.setClass(this.celle[this.position], 'cancellatoVeloce');
        else
            this.setClass(this.celle[this.position], 'cancellato');

        this.word = this.word.slice(0, -1);
        return 1;
    }

    enter() {
        if (this.end) {
            return 0;
        }
        if (this.position != this.lastSent + 5) {
            this.notExists();

            return 1;
        }
        if (this.word.length != 5) {
            this.notExists();

            this.error('Something went very wrong', this.querySelector);
        }

        this.sendWord();
        return 1;
    }

    sendWord() {
        let data = new FormData();
        data.set('word', this.word);

        fetch_php(data, '../php/sendWord.php', function (data) {

            if (data["ok"] === true) {
                console.log(data);
                if (data['exists']) {

                    this.setClass(this.celle[this.position - 1], 'esiste');
                    this.setClass(this.celle[this.position - 2], 'esiste');
                    this.setClass(this.celle[this.position - 3], 'esiste');
                    this.setClass(this.celle[this.position - 4], 'esiste');
                    this.setClass(this.celle[this.position - 5], 'esiste');
                    this.refresh();
                    this.word = '';
                }
                else
                    this.notExists();
            } else {
                console.log(data);
                this.error(data['error'], this.querySelector);
            }

        }.bind(this), this.onError.bind(this));

    }

    refresh() {
        let data = new FormData();
        console.log("refresh")

        fetch_php(data, '../php/gameStatus.php', function (data) {
            if (data["ok"] === true) {
                this.refreshboard(data);
            } else {
                console.log(data);
                this.error(data['error'], this.querySelector);
            }
        }.bind(this), this.onError.bind(this));
    }

    async refreshboard(data) {
        const colors = ['var(--color-absent)', 'var(--color-present)', 'var(--color-correct)'];
        console.log(data);
        for (let i = 0; i < 6; i++) {
            console.log(data[i]);
            let a = data[i];
            if (a != undefined) {
                for (let j = 0; j < 5; j++) {
                    this.celle[i * 5 + j].innerHTML = a["word"][j];
                    this.celle[i * 5 + j].style.backgroundColor = colors[a["result"][j]];

                    this.keyboard.setColor(a["word"][j], colors[a["result"][j]], a["result"][j]);
                }
                this.position = (i + 1) * 5;
                this.lastSent = (i + 1) * 5;



                if (i == 5 || a["correct"]) {
                    this.end = true;
                    delay(500).then(() => this.finish());
                    break;
                }
            }
        }
    }

    finish() {

        fetch_php(new FormData(), '../php/stats.php', this.showStats.bind(this), this.onError.bind(this));
        fetch_php(new FormData(), '../php/ranking.php', this.showRanking.bind(this), this.onError.bind(this));

    }

    showStats(data) {
        console.log("Statistiche")
        if (data["ok"] !== true) {
            console.log(data);
            this.error(data['error'], this.querySelector);
            return
        }

        let overlay = document.querySelector('#overlay');
        overlay.classList.remove('hidden');
        let stats = document.querySelectorAll('.stats');
        stats[0].innerHTML = data['gamesPlayed'];
        stats[1].innerHTML = data['gamesWon'];
        if (data['meanGuesses'] == null)
            data['meanGuesses'] = 'N/A';
        stats[2].innerHTML = data['meanGuesses'];
    }

    showRanking(data) {
        console.log("Classifica")
        if (data["ok"] !== true) {
            console.log(data);
            this.error(data['error'], this.querySelector);
        }
        console.log(this.a);

        console.log(data);
        let ranking = data['ranking'];
        let count = 1;
        let present = false;
        let pos = -1;
        let classifica = document.querySelector('#ranking');
        for (let a of ranking) {
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            td.innerHTML = count;
            tr.appendChild(td);

            td = document.createElement('td');
            td.innerHTML = a['username'];
            tr.appendChild(td);
            td = document.createElement('td');
            td.innerHTML = a['gamesWon'];
            tr.appendChild(td);
            classifica.appendChild(tr);
            count++;
            if (a['username'] === data['username']) {
                present = true;
                pos = count;
            }
        }
        let position = data['position'];


        if (!present) {
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            td.innerHTML = position + 1;
            tr.appendChild(td);
            td = document.createElement('td');
            td.innerHTML = data['username'];
            tr.appendChild(td);
            td = document.createElement('td');
            td.innerHTML = data['gamesWon'];
            tr.appendChild(td);

            tr.style.fontWeight = '700';
            classifica.appendChild(tr);
        } else {
            let tr = classifica.children[pos - 1];
            tr.style.fontWeight = '700';
        }


    }

    notExists() {
        for (let i = this.lastSent; i < this.lastSent + 5; i++) {
            this.setClass(this.celle[i], 'nonesiste');
        }
    }

}

let board = new tabella("#tabella");


document.addEventListener('keydown', function (event) {

    if (board.end) return;

    let posLet = getLetterPosition(event.key);
    if (posLet != -1) {

        let ok = board.letter(posLet);
        if (ok)
            sound("quiet")
    }
    if (event.key === 'Enter') {
        sound("loud");
        board.enter();
    }
    if (event.key === 'Backspace' || event.key == 'Escape') {

        if (board.position == board.lastSent) return;
        sound("loud")

        //if ctrl or alt is pressed too, delete the whole word
        if (event.ctrlKey || event.altKey || event.key == 'Escape') {
            console.log("5*backspace")
            for (let i = 0; i < 5; i++)
                board.backspace(1);
        } else {
            console.log("backspace")
            board.backspace();
        }
    }
});

document.querySelector('#overlay').addEventListener('click', function (event) {
    if (event.target.id === 'overlay' || event.target.id == 'closeIcon' || event.target.tagName === 'path') {
        this.classList.add('hidden');
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.querySelector('#overlay').classList.add('hidden');
    }
}
);
