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

    if (!isset($_POST['word'])) {
        throw new Exception("No word");
    }
    if (strlen($_POST['word']) != 5) {
        throw new Exception("Word is not 5 letters");
    }

    $word = $_POST['word'];

    $query = "  select word
                from word
                where word = ? 
                limit 1
             ";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $word);
    $statement->execute();

    // if no result from query, there is no account 
    if ($statement->rowCount() == 0) {
        $response = [
            'ok' => true,
            'exists' => false,
        ];
    } else {

        $response = [
            'ok' => true,
            'exists' => true,
        ];

        require_once "guess.php";
        guess($word, $_SESSION['userid']);
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