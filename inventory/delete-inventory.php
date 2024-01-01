<?php

if (isset($_GET["id"])) {
    require_once("../database.php");

    $isDeleted = Database::execute("DELETE FROM INVENTORY WHERE I_ID = :i_id", [
        ":i_id" => $_GET["id"],
    ]);

    echo "Successfully deleted";
} else {
    echo "Something went wrong!!!";
}