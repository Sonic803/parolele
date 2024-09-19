<?php

require_once "wordOfTheDay.php";

//Insert into the table standardGame the word,the curdate,the number of attempts and the id of the user
//This can be done after having checked the number of attempts of the user, they habe to be less than 6
function guess($word, $id)
{
    global $pdo;
    $query = "select * from standardGame where userID = ? and date = curdate()";
    $statement1 = $pdo->prepare($query);
    $statement1->bindValue(1, $id);
    $statement1->execute();

    if ($statement1->rowCount() < 6) {
        $query = "insert into standardGame (date, guess, userID, word) values (curdate(), ?, ?, ?)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(1, $statement1->rowCount() + 1);
        $statement->bindValue(2, $id);
        $statement->bindValue(3, $word);
        $statement->execute();

        if ($word == wordOfTheDay()) {
            $query = "insert into standardGamePlayed (date, userID, win, guesses) values (curdate(), ?, 1, ?)";
            $statement = $pdo->prepare($query);
            $statement->bindValue(1, $id);
            $statement->bindValue(2, $statement1->rowCount() + 1);
            $statement->execute();
        }

        if ($statement1->rowCount() == 5 && $word != wordOfTheDay()) {
            $query = "insert into standardGamePlayed (date, userID, win, guesses) values (curdate(), ?, 0, 6)";
            $statement = $pdo->prepare($query);
            $statement->bindValue(1, $id);
            $statement->execute();
        }
    }
}

?>