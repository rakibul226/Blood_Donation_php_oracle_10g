<?php

if (isset($_GET["id"])) {
    require_once("../database.php");

    $isDeleted = Database::execute("DELETE FROM DONOR WHERE D_ID = :d_id", [
        ":d_id" => $_GET["id"],
    ]);

    echo "Successfully deleted";
} else {
    echo "Something went wrong!!!";
}