"use strict";
function fetch_php(data, php, func, err) {
    fetch(php, {
        method: 'post',
        body: data,
    })
        .then(response => response.json())
        .then(data => {
            console.log(func);
            func(data);
        })
        .catch((error) => {
            err(error);
        });
}