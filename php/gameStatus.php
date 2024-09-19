<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}

require_once "connectDb.php";
require_once "wordOfTheDay.php";

try {

    $query = "  select word, guess
                from standardGame
                where userID = ? 
                and date = curdate() ";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_SESSION['userid']);
    $statement->execute();
    $response = [
        'ok' => true,
    ];
    for ($i = 0; $i < $statement->rowCount(); $i++) {
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $response[$i] = [
            'word' => $row['word'],
            'guess' => $row['guess'],
            'result' => confront($row['word'], wordOfTheDay()),
            'correct' => $row['word'] == wordOfTheDay()

        ];
    }

} catch (PDOException | Exception $e) {
    $response = [
        'ok' => false,
        'message' => 'Something went wrong',
        'error' => $e->getMessage()
    ];
}


echo json_encode($response);

$connection->close();
$pdo = null;
//Why is this important?
//
