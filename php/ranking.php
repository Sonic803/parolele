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
    $query = "
    select username, sum(standardGamePlayed.win) as gamesWon
    from standardGamePlayed
    join userLogin on standardGamePlayed.userID = userLogin.ID
    group by userLogin.ID
    order by gamesWon desc
    limit 10
";


    $statement = $pdo->prepare($query);
    $statement->execute();
    $ranking = $statement->fetchAll(PDO::FETCH_ASSOC);

    #User position in ranking
    $query = "
    select count(*) as position
    from (
        select sum(standardGamePlayed.win) as gamesWon
        from standardGamePlayed
        group by userID
        order by gamesWon desc
    ) as ranking
    where gamesWon > (
        select sum(standardGamePlayed.win) as gamesWon
        from standardGamePlayed
        where userID = ?
        group by userID
    )
";



    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_SESSION['userid']);
    $statement->execute();
    $position = $statement->fetch(PDO::FETCH_ASSOC);

    //Number of games won
    $query = "  select count(*)
            from standardGamePlayed
            where userID = ? and win = 1";
    $statement = $pdo->prepare($query);
    $statement->bindValue(1, $_SESSION['userid']);
    $statement->execute();
    $gamesWon = $statement->fetchColumn();



    $response = [
        'ok' => true,
        'ranking' => $ranking,
        'position' => $position['position'],
        'username' => $_SESSION['username'],
        'gamesWon' => $gamesWon
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