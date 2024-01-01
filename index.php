<?php

session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true") {
  header("Location: common/dashboard.php");
}

$title = "Home Page";
$message = "";

if (isset($_POST["login-submit"])) {
  $_name = sanitize_input($_POST["name"]);
  $_user_email = sanitize_input($_POST["user_email"]);
  $_user_type = sanitize_input($_POST["user_type"]);

  $name = "";
  $user_email = "";
  $user_type = "";

  $name_err = "";
  $user_email_err = "";
  $user_type_err = "";

  $has_err = false;

  if (empty($_name)) {
    $name_err = "Name is required";
    $has_err = true;
  } else {
    $name = $_name;
  }

  if (empty($_user_email)) {
    $user_email_err = "User Email is required";
    $has_err = true;}
  //  elseif (!is_numeric($_user_email)) {
  //   $user_email_err = "User Id must be numeric";
  //   $has_err = true;
  // }elseif (!is_($_user_email)) {
  //   $user_email_err = "User Id must be string";
  //   $has_err = true;
  // }
  else {
    $user_email = $_user_email;
  }

  if (empty($_user_type)) {
    $user_type_err = "User type is required";
    $has_err = true;
  } elseif (!preg_match("/^(patient|donor|bloodbank|executive)+$/", $_user_type)) {
    $user_type_err = "Invalid User type";
    $has_err = true;
  } else {
    $user_type = $_user_type;
  }

  if (!$has_err) {
    require_once("./database.php");

    $user = null;

    if ($user_type === "patient") {
      $user = Database::get(
        "SELECT * FROM PATIENT WHERE P_EMAIL = :p_email AND P_NAME = :p_name",
        [
          ":p_email" => $user_email,
          ":p_name" => $name
        ]
      );
    } elseif ($user_type === "donor") {
      $user = Database::get(
        "SELECT * FROM DONOR WHERE D_EMAIL = :d_email AND D_NAME = :d_name",
        [
          ":d_email" => $user_email,
          ":d_name" => $name
        ]
      );
    } elseif ($user_type === "bloodbank") {
      $user = Database::get(
        "SELECT * FROM BLOODBANK WHERE BB_EMAIL = :bb_email AND BB_NAME = :bb_name",
        [
          ":bb_email" => $user_email,
          ":bb_name" => $name
        ]
      );
    } elseif ($user_type === "executive") {
      $user = Database::get(
        "SELECT * FROM EXECUTIVE WHERE E_EMAIL = :e_email AND E_NAME = :e_name",
        [
          ":e_email" => $user_email,
          ":e_name" => $name
        ]
      );
    }

    // echo "<pre>";
    // var_dump($user_type, $user);
    // echo "</pre>";
    // exit();

    if ($user != null || (is_array($user) && count($user) > 0)) {
      $_SESSION["user_email"] = $user_email;
      $_SESSION["user_name"] = $name;
      $_SESSION["user_type"] = $user_type;
      $_SESSION["loggedin"] = "true";

      header("Location: common/dashboard.php");
    } else {
      $message = "Invalid credential";
    }
  }
}

function sanitize_input($input)
{
  return htmlentities(htmlspecialchars(trim($input)));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $title ?? ""; ?></title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>  
    <div class="main">
<header>
  <h1>Central Blood Bank</h1>
</header>
<main>
  <form method="post">
    <label></label>
    <div>
      <p>
        <?php echo isset($message) && !empty($message) ? $message : ""; ?>
      </p>
    </div>
    <label for="user_type">User Type: </label>
    <div>
      <select name="user_type" id="user_type">
        <option value="">You are!</option>
        <option value="patient">Patient</option>
        <option value="donor">Donor</option>
        <option value="bloodbank">Blood Bank</option>
        <option value="executive">Executive</option>
        
      </select>
      <p class="error">
        <?php echo isset($user_type_err) ? $user_type_err : ""; ?>
      </p>
    </div>

    <label for="name">Name: </label>
    <div>
      <input type="text" name="name" id="name" />
      <p class="error">
        <?php echo isset($name_err) ? $name_err : ""; ?>
      </p>
    </div>

    <label for="user_email">Email: </label>
    <div>
      <input type="text" name="user_email" id="user_email" />
      <p class="error">
        <?php echo isset($user_email_err) ? $user_email_err : ""; ?>
      </p>
    </div>

    <input type="submit" id="login-submit" name="login-submit" value="Login" />
    <br>
    <br>
    <br>
    <h6> If you don't have account->
   
    <a href="./common/signup.php">Signup</a>
    </h6>
  </form>
</main>

<?php include_once("./templates/footer.php");