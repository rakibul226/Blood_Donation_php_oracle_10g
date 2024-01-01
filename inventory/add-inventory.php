<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "executive" || $_SESSION["user_type"] == "bloodbank"))) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
$title = "Add Inventory";
$result = null;


// echo "</pre>";
// exit();

if (isset($_POST["add-inventory-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN INSERT_INVENTORY(:i_name, :i_address, :i_bloodgroup, :i_amount, :ph_number);END;",
    [
      ":i_name" => $_POST["name"],
      ":i_address" => $_POST["address"],
      ":i_bloodgroup" => $_POST["bloodgroup"],
      ":i_amount" => $_POST["amount"],
      ":ph_number" => $_POST["phone"]
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
<h1>Register New Inventory</h1>
</header>
<form method="post">

<label for="name">Name: </label>
  <div>
    <input type="text" name="name" id="name" />
    <p class="error"></p>
  </div>

  
  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" />
    <p class="error"></p>
  </div>


  <label for="bloodgroup">Blood Group: </label>
  <div>
    <select name="bloodgroup" id="bloodgroup">
      <option>Select Blood Group</option>
      <option value="A+" >A+</option>
      <option value="A-">A-</option>
      <option value="B+" >B+</option>
      <option value="B-">B-</option>
      <option value="AB+">AB+</option>
      <option value="AB-">AB-</option>
      <option value="O+">O+</option>
      <option value="O-">O-</option>
    </select>
    <p class="error"></p>
  </div>

  <label for="amount">Amount: </label>
  <div>
    <input type="text" name="amount" id="amount"  />
    <p class="error"></p>
  </div>

  <label for="phone">Phone: </label>
  <div>
    <input type="text" name="phone" id="phone"  />
    <p class="error"></p>
  </div>

  <input type="submit" id="add-inventory-submit" name="add-inventory-submit" value="submit" />
</form>
<?php include_once("../templates/footer.php");