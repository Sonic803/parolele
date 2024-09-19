<?php
// If called with $_POST['reset'] == 'true', reset the word of the day
// If called with $_POST['check'] == 'true', return the word of the day

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['admin'] != 1) {
    header("Location: ../index.php");
    exit();
}

require_once "connectDb.php";

require_once "wordOfTheDay.php";


if (isset($_POST['reset'])) {

    $word = generateWord();
    $query = "update wordOfTheDay set word = ? where date = curdate()";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $word);
    $statement->execute();

    $response = [
        'newWord' => $word,
    ];

    //Remove all records from standardGame where date = curdate()
    $query = "delete from standardGame where date = curdate()";
    $statement = $pdo->prepare($query);
    $statement->execute();

    $query = "delete from standardGamePlayed where date = curdate()";
    $statement = $pdo->prepare($query);
    $statement->execute();

    echo json_encode($response);

    $connection->close();
    $pdo = null;
}

if (isset($_POST['check'])) {

    $response = [
        'word' => wordOfTheDay(),
    ];
    echo json_encode($response);

    $connection->close();
    $pdo = null;
}