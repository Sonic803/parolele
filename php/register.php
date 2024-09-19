<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "connectDb.php";



try {

    if (!isset($_POST['username'])) {
        throw new Exception("Incorrect credentials");
    }
    if (!isset($_POST['hash'])) {
        throw new Exception("Incorrect credentials");
    }
    if (strlen($_POST['username']) > 20) {
        throw new Exception("Username too long!");
    }

    if (strlen($_POST['hash']) != 64) {
        throw new Exception("Wrong Hash length!");
    }

    $query = "insert into userLogin (username, hash,admin) values (?,?,0)";

    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_POST['username']);
    //Hash with salt
    $statement->bindValue(2, password_hash($_POST['hash'], PASSWORD_DEFAULT));
    try {
        $statement->execute();
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            throw new Exception("Username already taken");
        } else {
            throw new Exception("Registration failed");
        }
    }

    $query = "select LAST_INSERT_ID()";
    $statement = $pdo->prepare($query);
    $statement->execute();



    $id = $statement->fetch(PDO::FETCH_NUM);
    $id = $id[0];

    // Login
    $_SESSION['login'] = true;
    $_SESSION['userid'] = $id;
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['admin'] = 0;

    $response = [
        'register' => true,
        'message' => 'Account registered',
    ];

} catch (PDOException | Exception $e) {
    $response = [
        'register' => false,
        'message' => 'Registration failed',
        'error' => $e->getMessage(),
    ];
}

echo json_encode($response);

$connection->close();
$pdo = null;

?>