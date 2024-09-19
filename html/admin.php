<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// if not admin, redirect to home
if ((!isset($_SESSION['admin']) || $_SESSION['admin'] == false)) {
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
    <link rel="stylesheet" href="../css/admin.css">

    <script src="../js/fetch.js"></script>
    <script defer src="../js/darkMode.js"></script>
    <script src="../js/admin.js"></script>
</head>

<body class="light-mode" onload="start();paroladelgiorno();">

    <?php include '../php/topBar.inc.php'; ?>

    <main>
        <button onclick="resetDay()">Reset word of the day</button>
        <details class="wordOfTheDay">
            <summary>Parola del giorno</summary>
            hey
        </details>
    </main>

</body>

</html>