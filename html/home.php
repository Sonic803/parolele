<!DOCTYPE html>
<html lang="it">

<head>
    <title>Parolele</title>

    <link rel="icon" type="image/png" href="../icon/favicon-256x256.png">

    <!-- Per evitare che da mobile si possa zoommare -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="../manifest.webmanifest">

    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/topNavigation.css">
    <link rel="stylesheet" href="../css/home.css">

    <script defer src="../js/darkMode.js"></script>

</head>

<body class="light-mode" onload="start()">

    <?php include '../php/topBar.inc.php'; ?>

    <main>
        <h1>Parolele</h1>
        <h2>Introduzione</h2>
        <p>Questo sito prende spunto da
            <a href="https://www.nytimes.com/games/wordle">Wordle</a>, un gioco in cui ogni giorno è scelta una parola
            di 5 lettere che l'utente con al massimo 6 tentativi deve provare ad indovinare.
        </p>

        <h2>Registrazione</h2>
        <p>Per giocare è necessario registrarsi, per farlo è sufficiente cliccare sul pulsante
            <a href="./login.php">Login/Register</a> nella barra in alto a destra ed inserire username e password.
        </p>

        <h2>Gioco</h2>
        <p>Una volta loggati è possibile <a href="./game.php">giocare</a>, dopo aver scritto la parola e premuto il
            pulsante invio esso sarà considerato un tentativo valido solo se la parola tentata fa parte del
            <a href="https://github.com/napolux/paroleitaliane">dizionario del gioco</a>.
            <br>
            Nel caso in cui lo sia verranno dati degli aiuti per ogni lettera della parola, lo sfondo della lettera
            diventa:
        </p>
        <ul>
            <li><span id="verde">Verde</span> se la lettera è presente nella parola da indovinare,
                nella stessa posizione che ha nella parola inviata.</li>
            <li><span id="giallo">Giallo</span> se la lettera è presente nella parola da indovinare,
                ma non nella stessa posizione che ha nella parola inviata.</li>
            <li><span id="grigio">Grigio</span> se non è presente nella parola da indovinare.</li>
        </ul>
        <p>
            Oltre alla tabella è presente una tastiera che indica gli aiuti ricevuti per ogni lettera,
            essa può inoltre essere usata per inserire la parola.
        </p>
        <h2>Classifica</h2>
        <p>Dopo aver indovinato la parola o dopo 6 tentativi errati compare un overlay con delle stastiche sulle
            partite giocate, e la classifica con i giocatori migliori.
        </p>
        <h2>Dark Mode</h2>
        <p>Il sito supporta la posssibilità di usare la dark mode, per attivarla o disattivarla basta premere
            l'interruttore in alto a destra, la preferenza verrà salvata sul dispositivo e verrà applicata ogni
            volta che si accede al sito.
        </p>
    </main>
</body>

</html>