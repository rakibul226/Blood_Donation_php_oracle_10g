<?php

if (isset($_GET["id"])) {
    require_once("../database.php");

    $isDeleted = Database::execute("DELETE FROM BLOODREQUEST WHERE BR_ID = :br_id", [
        ":br_id" => $_GET["id"],
    ]);

    echo "Successfully deleted";
} else {
    echo "Something went wrong!!!";
}