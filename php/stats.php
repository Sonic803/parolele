<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit();
}

require_once "connectDb.php";

try {
    //Number of games played
    $query = "  select count(*)
            from standardGamePlayed
            where userID = ?";

    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_SESSION['userid']);
    $statement->execute();
    $gamesPlayed = $statement->fetchColumn();

    //Number of games won
    $query = "  select count(*)
            from standardGamePlayed
            where userID = ? and win = 1";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_SESSION['userid']);
    $statement->execute();
    $gamesWon = $statement->fetchColumn();

    //Mean number of guesses in won games
    $query = "  select truncate(avg(guesses),1)
            from standardGamePlayed
            where userID = ? and win = 1";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_SESSION['userid']);
    $statement->execute();
    $meanGuesses = $statement->fetchColumn();


    $response = [
        'ok' => true,
        'gamesPlayed' => $gamesPlayed,
        'gamesWon' => $gamesWon,
        'meanGuesses' => $meanGuesses,
    ];

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

?>