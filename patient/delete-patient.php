<?php

if (isset($_GET["id"])) {
    require_once("../database.php");

    $isDeleted = Database::execute("DELETE FROM PATIENT WHERE P_ID = :p_id", [
        ":p_id" => $_GET["id"],
    ]);

    echo "Successfully deleted";
} else {
    echo "Something went wrong!!!";
}