<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// if not logged in, redirect to home
if (!isset($_SESSION['username'])) {
    header("Location:home.php");
    exit();
}
?>
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
    <link rel="stylesheet" href="../css/game.css">

    <script src="../js/fetch.js"></script>
    <script defer src="../js/darkMode.js"></script>
</head>

<body class="light-mode" onload="start()">

    <?php include '../php/topBar.inc.php' ?>

    <main>
        <div id="overlay" class="hidden">
            <div id="overlayBox">
                <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 0 48 48" width="48">
                    <path
                        d="M35.314 8.444 24 19.757 12.686 8.444a1 1 0 0 0-1.414 0l-2.828 2.828a1 1 0 0 0 0 1.414L19.757 24 8.444 35.314a1 1 0 0 0 0 1.414l2.828 2.828a1 1 0 0 0 1.414 0L24 28.243l11.314 11.313a1 1 0 0 0 1.414 0l2.828-2.828a1 1 0 0 0 0-1.414L28.243 24l11.313-11.314a1 1 0 0 0 0-1.414l-2.828-2.828a1 1 0 0 0-1.414 0Z" />
                </svg>

                <h2>Statistiche</h2>
                <div id="statistiche">
                    <div id="gamesPlayed" class="statsContainer">
                        <span class="stats"></span>
                        <span class="statsLabel">Partite Giocate</span>
                    </div>
                    <div id="gamesWon" class="statsContainer">
                        <span class="stats"></span>
                        <span class="statsLabel">Partite Vinte</span>
                    </div>
                    <div id="meanGuesses" class="statsContainer">
                        <span class="stats"></span>
                        <span class="statsLabel">Numero medio di tentativi</span>
                    </div>
                </div>
                <h2>Classifica</h2>
                <div id="classifica">
                    <table id="ranking">
                        <tr>
                            <th>Posizione</th>
                            <th>Username</th>
                            <th>Partite Vinte</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <table id="tabella" class="unselectable"></table>
        <p class="game error hidden">Something went very wrong...</p>
        <table id="keyboard" class="unselectable"></table>
    </main>
    <script src="../js/keyboard.js"></script>
    <script src="../js/game.js"></script>

</body>

</html>