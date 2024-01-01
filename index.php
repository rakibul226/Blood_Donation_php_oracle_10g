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
    $has_err = true;
  } else {
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <title><?php echo $title ?? ""; ?></title>
</head>

<body class="bg-gray-600 flex items-center justify-center min-h-screen">

  <div class="bg-white bg-opacity-80 p-8 rounded-md shadow-md max-w-md w-full">
    <div class="mb-4">
      <p class="text-red-500">
        <?php echo isset($message) && !empty($message) ? $message : ""; ?>
      </p>
    </div>

    <div class="mb-4">
      <label for="user_type" class="block text-gray-700">User Type:</label>
      <select name="user_type" id="user_type" class="mt-1 block w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <option value="">You are!</option>
        <option value="patient">Patient</option>
        <option value="donor">Donor</option>
        <option value="bloodbank">Blood Bank</option>
        <option value="executive">Executive</option>
      </select>
      <p class="text-red-500">
        <?php echo isset($user_type_err) ? $user_type_err : ""; ?>
      </p>
    </div>

    <div class="mb-4">
      <label for="name" class="block text-gray-700">Name:</label>
      <input type="text" name="name" id="name" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
      <p class="text-red-500">
        <?php echo isset($name_err) ? $name_err : ""; ?>
      </p>
    </div>

    <div class="mb-4">
      <label for="user_email" class="block text-gray-700">Email:</label>
      <input type="text" name="user_email" id="user_email" class="mt-1 p-2 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
      <p class="text-red-500">
        <?php echo isset($user_email_err) ? $user_email_err : ""; ?>
      </p>
    </div>

    <button type="submit" id="login-submit" name="login-submit" class="mt-2 w-full bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-purple-600 focus:outline-none focus:ring focus:border-purple-300 active:bg-purple-800">
      Login
    </button>

    <div class="mt-4">
      <span class="text-right">
        <a href="./common/signup.php" class="inline-block">Not a member? Sign Up</a>
      </span>
    </div>
  </div>

</body>

</html>
