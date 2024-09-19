<?php

class connectDB
{
    public $pdo;

    function __construct()
    {
        try {
            $connection = "mysql:host=127.0.0.1;dbname=ciociola_645324";
            $user = "root";
            $pass = "";

            $this->pdo = new PDO(
                $connection,
                $user,
                $pass,
                array(
                        PDO::ATTR_PERSISTENT => false
                )
            );

        } catch (PDOException $e) {

            $response = ['error' => $e->getMessage()];
            die(json_encode($response));

        }
    }

    function getPDO()
    {
        return $this->pdo;
    }

    function close()
    {
        $this->pdo = null;
    }
}

$connection = new connectDB();
$pdo = $connection->getPDO();

?>