<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "patient")) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
$title = "Blood Request";
$result = null;






if (isset($_POST["blood-request-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN INSERT_BLOODREQUEST(:br_name, :br_email, :br_bloodgroup, :br_amount);END;",
    [
      ":br_name" => $_POST["name"],
      ":br_email" => $_POST["email"],
      ":br_bloodgroup" => $_POST["bloodgroup"],
      ":br_amount" => $_POST["amount"]
    ]
  );


  // echo "<pre>";
  // var_dump($result);
  // echo "</pre>";
}
?>
<header>
  
  <?php
  if ($result >= 1) {
    echo '<h2 style="color:green;">Successfully added!</h2>';
  } elseif ($result === 0) {

    echo '<h2 style="color:red;">Not successfully added!</h2>';
  }
  ?>
</header>

<?php include_once("../templates/header.php"); ?>
<header>
<h1>Make Blood Request</h1>
</header>

<form method="post">

<label for="name">Patient Name: </label>
<div>
    <input type="text" name="name" id="name" />
    <p class="error"></p>
  </div>

  <label for="email">Patient Email: </label>
<div>
    <input type="text" name="email" id="email" />
    <p class="error"></p>
  </div>


  <label for="bloodgroup">Blood Group: </label>
  <div>
    <select name="bloodgroup" id="bloodgroup">
      <option>Select Blood Group</option>
      <option value="A+">A+</option>
      <option value="A-">A-</option>
      <option value="B+">B+</option>
      <option value="B-">B-</option>
      <option value="AB+">AB+</option>
      <option value="AB-">AB-</option>
      <option value="O+">O+</option>
      <option value="O-">O-</option>
    </select>
    <p class="error"></p>
  </div>
  <label for="amount">Amount of Blood Need: </label>
  <div>
    <input type="text" name="amount" id="amount" />
    <p class="error"></p>
  </div>

  <input type="submit" id="blood-request-submit" name="blood-request-submit" value="submit" />


</form>
<?php include_once("../templates/footer.php");