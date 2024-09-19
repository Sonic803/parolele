<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "connectDb.php";


try {

    if (!isset($_POST['username'])) {
        throw new Exception("No username");
    }

    if (!isset($_POST['hash'])) {
        throw new Exception("No hash");
    }

    $username = $_POST['username'];
    $password = $_POST['hash'];


    $query = "  select ID, hash, admin
                from userLogin 
                where username = ? 
                limit 1
             ";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $username);
    $statement->execute();

    // if no result from query, there is no account 
    if ($statement->rowCount() == 0) {
        throw new Exception("Incorrect credentials");
    } else if ($statement->rowCount() > 1) {
        throw new Exception("Multiple accounts with same username (this should not happen)");
    } else {
        $account = $statement->fetch(pdo::FETCH_ASSOC);
        if (password_verify($password, $account['hash'])) {

            $_SESSION['login'] = true;
            $_SESSION['userid'] = $account['ID'];
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $account['admin'];

            $response = [
                'login' => true,
                'user' => $username,
                'message' => 'Logged in',
            ];

        } else {
            throw new Exception("Incorrect credentials");
        }
    }

} catch (PDOException | Exception $e) {
    $response = [
        'login' => false,
        'message' => 'Login failed',
        'error' => $e->getMessage()
    ];
}

echo json_encode($response);

$connection->close();
$pdo = null;

?>