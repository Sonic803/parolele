<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$leftList = '';
$rightList = '';


$links = [
    "Home" => "./home.php",
];

if (isset($_SESSION['login'])) {
    $links += [
        "Game" => "./game.php",
    ];
}else{
    $links += [
        "Doc" => "../documentation.html",
    ];
}

if (isset($_SESSION['login']) && $_SESSION['admin']) {
    $links += [
        "Admin " => "./admin.php",
    ];
}


foreach ($links as $key => $link) {
    $a = "<a href='$link'> $key </a>";
    $leftList = $leftList . "<li> $a </li>";
}


$links = [];

if (isset($_SESSION['login'])) {
    $links += [
        "Logout" => "../php/logout.php",
    ];
} else {
    $links += [
        "Login/Register" => "./login.php",
    ];
}


foreach ($links as $key => $link) {
    $a = "<a href='$link'> $key </a>";
    $rightList = $rightList . "<li> $a </li>";
}

?>

<nav class="topNavigation">

    <ul class="left">
        <?php echo $leftList; ?>
    </ul>
    <label class="switch">
        <input type="checkbox" onclick="changeMode()" id="switchMode">
        <span class="slider round"></span>
    </label>
    <ul class="right">
        <?php echo $rightList; ?>
    </ul>
</nav>