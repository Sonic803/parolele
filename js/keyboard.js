"use strict";
function simulate(key) {
    navigator.vibrate(30);
    let event = new KeyboardEvent('keydown', { key: key });
    document.dispatchEvent(event);
}

class keyboard {
    constructor() {
        const qwertyalphabet = 'qwertyuiopasdfghjklzxcvbnm';
        const columns = [10, 9, 7]
        let count = 0;
        this.keyboard = document.getElementById("keyboard");
        this.keyboard.innerHTML = '';
        for (let i = 0; i < 3; i++) {
            let row = document.createElement('tr');
            row.className = 'riga';
            for (let j = 0; j < columns[i]; j++) {
                let cell = document.createElement('td');
                cell.className = 'cella';
                cell.innerHTML = qwertyalphabet[count];
                cell.onclick = simulate.bind(null, qwertyalphabet[count]);
                row.appendChild(cell);
                count++;
            }
            this.keyboard.appendChild(row);
        }

        let enter = document.createElement('td');
        enter.className = 'cella enter';
        enter.innerHTML = 'enter';
        enter.onclick = simulate.bind(null, 'Enter');
        this.keyboard.lastChild.appendChild(enter);

        let back = document.createElement('td');
        back.className = 'cella backspace';
        back.innerHTML = 'back';
        back.onclick = simulate.bind(null, 'Backspace');
        this.keyboard.lastChild.insertBefore(back, this.keyboard.lastChild.firstChild);

        //enter a empty cell on the second and third row
        let empty = document.createElement('td');
        empty.className = 'cella';
        empty.innerHTML = '';
        empty.style.display = 'none';
        this.keyboard.firstChild.nextSibling.appendChild(empty);
        this.keyboard.firstChild.nextSibling.nextSibling.appendChild(empty.cloneNode(true));


        this.cells = document.querySelectorAll('#keyboard > .riga > .cella');
        for (let i = 0; i < this.cells.length; i++) {
            this.cells[i].prio = -1;
        }
    }

    setColor(letter, color, prio) {
        for (let i = 0; i < this.cells.length; i++) {
            if (this.cells[i].innerHTML == letter && prio > this.cells[i].prio) {
                this.cells[i].style.backgroundColor = color;
                this.cells[i].prio = prio;
            }
        }
    }

}
