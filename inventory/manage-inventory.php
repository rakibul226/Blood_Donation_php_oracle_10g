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
$title = "Manage Inventory";
$result = null;

if (!isset($_GET["id"])){
  echo "<h1>Id is not provide</h1>";
  exit();
} else if (empty($_GET["id"])) {
  echo "<h1>Id can't be empty</h1>";
  exit();
} else if (!is_numeric($_GET["id"])) {
  echo "<h1>Id must be numeric</h1>";
  exit();
}

require_once("../database.php");

$id = $_GET["id"];
$sql = "SELECT * FROM INVENTORY WHERE I_ID = :i_id";
$inventory = Database::get($sql, [":i_id" => $id]);

if (count($inventory) == 0) {
  echo "<h1>Invalid ID</h1>";
  exit();
}

$inventory = $inventory[0];
$phone = Database::get("SELECT * FROM PHONE WHERE PH_ID = :ph_id", [":ph_id" => $inventory["PH_ID"]])[0];

// echo "<pre>";
// var_dump($inventory);
// echo "</pre>";
// exit();

if (isset($_POST["manage-inventory-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN UPDATE_INVENTORY(:i_id, :i_name, :i_address, :i_bloodgroup, :i_amount, :ph_number);END;",
    [
      ":i_id" => $_POST["id"],
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
<h1>Manage Inventory</h1>

<form method="post">

<label for="id">Id: </label>
  <div>
    <input type="text" name="id" id="id" value="<?php echo isset($inventory["I_ID"]) ? $inventory["I_ID"] : ""; ?>" />
    <p class="error"></p>
  </div>

  <label for="name">Name: </label>
  <div>
    <input type="text" name="name" id="name" value="<?php echo isset($inventory["I_NAME"]) ? $inventory["I_NAME"] : ""; ?>" />
    <p class="error"></p>
  </div>

  
  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" value="<?php echo isset($inventory["I_ADDRESS"]) ? $inventory["I_ADDRESS"] : ""; ?>" />
    <p class="error"></p>
  </div>


  <label for="bloodgroup">Blood Group: </label>
  <div>
    <select name="bloodgroup" id="bloodgroup">
      <option>Select Blood Group</option>
      <option value="A+" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "A+" ? "selected" : ""; ?>>A+</option>
      <option value="A-" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "A-" ? "selected" : ""; ?>>A-</option>
      <option value="B+" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "B+" ? "selected" : ""; ?>>B+</option>
      <option value="B-" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "B-" ? "selected" : ""; ?>>B-</option>
      <option value="AB+" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "AB+" ? "selected" : ""; ?>>AB+</option>
      <option value="AB-" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "AB-" ? "selected" : ""; ?>>AB-</option>
      <option value="O+" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "O+" ? "selected" : ""; ?>>O+</option>
      <option value="O-" <?php echo isset($inventory["I_BLOODGROUP"]) && $inventory["I_BLOODGROUP"] == "O-" ? "selected" : ""; ?>>O-</option>
    </select>
    <p class="error"></p>
  </div>

  <label for="amount">Amount: </label>
  <div>
    <input type="text" name="amount" id="amount" value="<?php echo isset($inventory["I_AMOUNT"]) ? $inventory["I_AMOUNT"] : ""; ?>" />
    <p class="error"></p>
  </div>

  <label for="phone">Phone: </label>
  <div>
    <input type="text" name="phone" id="phone" value="<?php echo isset($phone["PHONE"]) ? $phone["PHONE"] : ""; ?>"  />
    <p class="error"></p>
  </div>

  <input type="submit" id="manage-inventory-submit" name="manage-inventory-submit" value="submit" />
</form>
<?php include_once("../templates/footer.php");