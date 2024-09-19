<?php

function generateWord()
{
    global $pdo;
    $query = "select word from word order by rand() limit 1";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $word = $statement->fetch(pdo::FETCH_ASSOC)['word'];
    return $word;
}

// Generate a new word of the day if it doesn't exist, or get the current word of the day and return it
function wordOfTheDay()
{
    global $pdo;
    $query = "select word from wordOfTheDay where date = curdate()";
    $statement = $pdo->prepare($query);
    $statement->execute();


    if ($statement->rowCount() == 0) {
        $word = generateWord();
        $query = "insert into wordOfTheDay (word, date) values (?, curdate())";
        $statement = $pdo->prepare($query);
        $statement->bindValue(1, $word);
        $statement->execute();
        $trueWord = $word;
    } else {
        $trueWord = $statement->fetch(pdo::FETCH_ASSOC)['word'];
    }
    return $trueWord;

}

function confront($sentWord, $trueWord)
{
    $letters = str_split($sentWord);

    $trueLetters = str_split($trueWord);

    for ($i = 0; $i < 5; $i++) {
        if ($letters[$i] == $trueLetters[$i]) {
            $response[$i] = 2;
            $trueLetters[$i] = 0;
        }
    }
    for ($i = 0; $i < 5; $i++) {
        if ($trueLetters[$i] != 0) {
            if (in_array($letters[$i], $trueLetters))
                $response[$i] = 1;
            else
                $response[$i] = 0;
        }
    }
    return $response;
}