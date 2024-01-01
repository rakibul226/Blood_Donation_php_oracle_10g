<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "executive" || $_SESSION["user_type"] == "bloodbank" || $_SESSION["user_type"] == "patient"))) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
$title = "Edit Patient Profile";
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
$sql = "SELECT * FROM PATIENT WHERE P_ID = :p_id";
$patient = Database::get($sql, [":p_id" => $id]);

if (count($patient) == 0) {
  echo "<h1>Invalid ID</h1>";
  exit();
}

$patient = $patient[0];
$phone = Database::get("SELECT * FROM PHONE WHERE PH_ID = :ph_id", [":ph_id" => $patient["PH_ID"]])[0];

// echo "<pre>";
// var_dump($inventory);
// echo "</pre>";
// exit();

if (isset($_POST["edit-patient-profile-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN UPDATE_PATIENT(:p_id, :p_name,:p_email, :p_gender, :p_address, :p_bloodgroup, :ph_number);END;",
    [
      ":p_id" => $_POST["id"],
      ":p_name" => $_POST["name"],
      ":p_email" => $_POST["email"],
      ":p_gender" => $_POST["gender"],
      ":p_address" => $_POST["address"],
      ":p_bloodgroup" => $_POST["bloodgroup"],
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
<h1>Edit Patient Profile</h1>

<form method="post">

<label for="id">Id: </label>
  <div>
    <input type="text" name="id" id="id" value="<?php echo isset($patient["P_ID"]) ? $patient["P_ID"] : ""; ?>" />
    <p class="error"></p>
  </div>

  <label for="name">Name: </label>
  <div>
    <input type="text" name="name" id="name" value="<?php echo isset($patient["P_NAME"]) ? $patient["P_NAME"] : ""; ?>" />
    <p class="error"></p>
  </div>

  
  <label for="email">Email: </label>
  <div>
    <input type="text" name="email" id="email" value="<?php echo isset($patient["P_EMAIL"]) ? $patient["P_EMAIL"] : ""; ?>" />
    <p class="error"></p>
  </div>

  <label for="gender">Gender: </label>
  <div>
    <input type="text" name="gender" id="gender" value="<?php echo isset($patient["P_GENDER"]) ? $patient["P_GENDER"] : ""; ?>" />
    <p class="error"></p>
  </div>

  
  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" value="<?php echo isset($patient["P_ADDRESS"]) ? $patient["P_ADDRESS"] : ""; ?>" />
    <p class="error"></p>
  </div>


  <label for="bloodgroup">Blood Group: </label>
  <div>
    <select name="bloodgroup" id="bloodgroup">
      <option>Select Blood Group</option>
      <option value="A+" <?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "A+" ? "selected" : ""; ?>>A+</option>
      <option value="A-" <?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "A-" ? "selected" : ""; ?>>A-</option>
      <option value="B+" <?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "B+" ? "selected" : ""; ?>>B+</option>
      <option value="B-" <?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "B-" ? "selected" : ""; ?>>B-</option>
      <option value="AB+"<?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "AB+" ? "selected" : ""; ?>>AB+</option>
      <option value="AB-"<?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "AB-" ? "selected" : ""; ?>>AB-</option>
      <option value="O+" <?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "O+" ? "selected" : ""; ?>>O+</option>
      <option value="O-" <?php echo isset($patient["P_BLOODGROUP"]) && $patient["P_BLOODGROUP"] == "O-" ? "selected" : ""; ?>>O-</option>
    </select>
    <p class="error"></p>
  </div>

  <label for="phone">Phone: </label>
  <div>
    <input type="text" name="phone" id="phone" value="<?php echo isset($phone["PHONE"]) ? $phone["PHONE"] : ""; ?>"  />
    <p class="error"></p>
  </div>

  <input type="submit" id="edit-patient-profile-submit" name="edit-patient-profile-submit" value="submit" />
</form>
<?php include_once("../templates/footer.php");