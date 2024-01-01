<?php

final class Database
{
    private const DB_PORT = "1521";
    private const DB_HOST = "localhost";
    private const DB_USERNAME = "CentralBloodBank";
    private const DB_PASSWORD = "blood";
    private const DB_SERVICE = "XE";
    private const DB_CONNECTION_STRING = "oci:dbname=//" . self::DB_HOST . ":" . self::DB_PORT . "/" . self::DB_SERVICE;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function getConnection(): PDO|null
    {
        try {
            $pdo = new PDO(self::DB_CONNECTION_STRING, self::DB_USERNAME, self::DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $pdo;
        } catch (PDOException $e) {

            echo $e->getMessage();

        }

        return null;
    }

    public static function execute($query, $bindparams = [])
    {
        $conn = Database::getConnection();

        $affected_rows = 0;

        if ($conn) {
            try {
                $stmt = $conn->prepare($query);
                $stmt->execute($bindparams);

                $affected_rows = $stmt->rowCount();
            } catch (PDOException $e) {

                var_dump($e->getMessage());
                exit();
            }
        }

        $conn = null;

        return $affected_rows;
    }

    public static function get($query, $bindparams = [])
    {
        $conn = Database::getConnection();

        $results = [];

        if ($conn) {
            try {
                $stmt = $conn->prepare($query);
                $stmt->execute($bindparams);

                $results = $stmt->fetchAll();
            } catch (PDOException $e) {

                var_dump($e->getMessage());
                exit();
            }
        }

        $conn = null;

        return $results;
    }
}

// Database::get() -> select query -> return array
// Database::execute() -> insert, update, delete -> return boolean


//////////
// CRUD //
//////////

// CREATE

// $isInserted = Database::execute(
//     "INSERT INTO PATIENT (P_ID, P_NAME, P_GENDER, P_ADDRESS, P_BLOODGROUP, PH_ID) VALUES(:p_id, :p_name, :p_gender, :p_address, :p_bloodgroup, :p_ph_id)",
//     [
//         ":p_id" => 2027,
//         ":p_name" => "Test Patient Name",
//         ":p_gender" => "male",
//         ":p_address" => "Test address",
//         ":p_bloodgroup" => "O+",
//         ":p_ph_id" => 1013,
//     ]
// );

// var_dump($isInserted > 0);

// READ
// $patient = Database::get('SELECT * FROM PATIENT WHERE P_ID = :p_id', [
//     ':p_id' => 2021
// ]);
// $patients = Database::get('SELECT * FROM PATIENT');
// echo '<pre>';
// var_dump($patient);
// echo '<br><br>';
// var_dump($patients);
// echo '</pre>';


// UPDATE

// $isUpadated = Database::execute(
//     "UPDATE PATIENT SET P_NAME = :p_name WHERE P_ID = :p_id",
//     [
//         ":p_id" => 2027,
//         ":p_name" => "Test Patient Name UPDATE"
//     ]
// );

// var_dump($isUpadated > 0);


// DELETE

// $isDeleted = Database::execute(
//     "DELETE PATIENT WHERE P_ID = :p_id",
//     [
//         ":p_id" => 2027
//     ]
// );

// var_dump($isDeleted > 0);