<?php
include_once("../templates/header.php");

if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true")) {
    header("Location: index.php");
}
?>

<h1>Welcome  <?php echo $_SESSION["user_type"];?></h1>

<?php include_once("../templates/footer.php");