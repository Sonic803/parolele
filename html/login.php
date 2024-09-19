<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// if logged in, redirect to home
if (isset($_SESSION['username'])) {
    header("Location:home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <title>Parolele Login</title>

    <link rel="icon" type="image/png" href="../icon/favicon-256x256.png">

    <!-- Per evitare che da mobile si possa zoommare -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="manifest" href="../manifest.webmanifest">

    <link rel="stylesheet" href="../css/default.css">
    <link rel="stylesheet" href="../css/topNavigation.css">
    <link rel="stylesheet" href="../css/login.css">

    <script src="../js/fetch.js"></script>
    <script defer src="../js/darkMode.js"></script>

</head>

<body class="light-mode" onload="start()">

    <?php include '../php/topBar.inc.php' ?>

    <main>

        <form id="login">
            <fieldset>
                <legend>Login</legend>
                <p>
                    <label for="username">Username</label>
                    <input type="text" name="username" required>
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" name="password" required>
                </p>
                <p class="submit">
                    <input type="submit" value="Login">
                </p>

                <p class="login error hidden">Incorrect credentials</p>
            </fieldset>
        </form>

        <form id="register">
            <fieldset>
                <legend>Sign Up</legend>
                <p>
                    <label for="username">Username</label>
                    <input type="text" id="username" required minlength="5" maxlength="20">
                </p>
                <p>
                    <label for="password">Password</label>
                    <input type="password" id="password" required minlength="5" maxlength="32">
                </p>
                <p>
                    <label for="confirm">Confirm Password</label>
                    <input type="password" id="confirm" required minlength="5" maxlength="32">
                </p>

                <p class="register error hidden">Something went wrong...</p>

                <p class="submit">
                    <input type="submit" value="Create Account">
                </p>
            </fieldset>
        </form>
    </main>

    <script src="../js/registration.js"></script>
</body>

</html>