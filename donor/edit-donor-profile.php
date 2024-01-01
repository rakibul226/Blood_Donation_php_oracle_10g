<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "executive" || $_SESSION["user_type"] == "bloodbank" || $_SESSION["user_type"] == "donor"))) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
$title = "Edit Donor Profile";
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
$sql = "SELECT * FROM DONOR WHERE D_ID = :d_id";
$donor = Database::get($sql, [":d_id" => $id]);

if (count($donor) == 0) {
  echo "<h1>Invalid ID</h1>";
  exit();
}

$donor = $donor[0];
$phone = Database::get("SELECT * FROM PHONE WHERE PH_ID = :ph_id", [":ph_id" => $donor["PH_ID"]])[0];

// echo "<pre>";
// var_dump($inventory);
// echo "</pre>";
// exit();

if (isset($_POST["edit-donor-profile-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN UPDATE_DONOR(:d_id, :d_name,:d_email, :d_gender, :d_age, :d_bloodgroup, :d_address,  :ph_number);END;",
    [
      ":d_id" => $_POST["id"],
      ":d_name" => $_POST["name"],
      ":d_email" => $_POST["email"],
      ":d_gender" => $_POST["gender"],
      ":d_age" => $_POST["age"],
      ":d_bloodgroup" => $_POST["bloodgroup"],
      ":d_address" => $_POST["address"],
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
<h1>Edit Donor Profile</h1>

<form method="post">

<label for="id">Id: </label>
  <div>
    <input type="text" name="id" id="id" value="<?php echo isset($donor["D_ID"]) ? $donor["D_ID"] : ""; ?>" />
    <p class="error"></p>
  </div>

  <label for="name">Name: </label>
  <div>
    <input type="text" name="name" id="name" value="<?php echo isset($donor["D_NAME"]) ? $donor["D_NAME"] : ""; ?>" />
    <p class="error"></p>
  </div>

  
  <label for="email">Email: </label>
  <div>
    <input type="text" name="email" id="email" value="<?php echo isset($donor["D_EMAIL"]) ? $donor["D_EMAIL"] : ""; ?>" />
    <p class="error"></p>
  </div>

  <label for="gender">Gender: </label>
  <div>
    <input type="text" name="gender" id="gender" value="<?php echo isset($donor["D_GENDER"]) ? $donor["D_GENDER"] : ""; ?>" />
    <p class="error"></p>
  </div>

  
  <label for="age">Age: </label>
  <div>
    <input type="text" name="age" id="age" value="<?php echo isset($donor["D_AGE"]) ? $donor["D_AGE"] : ""; ?>" />
    <p class="error"></p>
  </div>

  
  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" value="<?php echo isset($donor["D_ADDRESS"]) ? $donor["D_ADDRESS"] : ""; ?>" />
    <p class="error"></p>
  </div>


  <label for="bloodgroup">Blood Group: </label>
  <div>
    <select name="bloodgroup" id="bloodgroup">
      <option>Select Blood Group</option>
      <option value="A+" <?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "A+" ? "selected" : ""; ?>>A+</option>
      <option value="A-" <?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "A-" ? "selected" : ""; ?>>A-</option>
      <option value="B+" <?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "B+" ? "selected" : ""; ?>>B+</option>
      <option value="B-" <?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "B-" ? "selected" : ""; ?>>B-</option>
      <option value="AB+"<?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "AB+" ? "selected" : ""; ?>>AB+</option>
      <option value="AB-"<?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "AB-" ? "selected" : ""; ?>>AB-</option>
      <option value="O+" <?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "O+" ? "selected" : ""; ?>>O+</option>
      <option value="O-" <?php echo isset($donor["D_BLOODGROUP"]) && $donor["D_BLOODGROUP"] == "O-" ? "selected" : ""; ?>>O-</option>
    </select>
    <p class="error"></p>
  </div>

  <label for="phone">Phone: </label>
  <div>
    <input type="text" name="phone" id="phone" value="<?php echo isset($phone["PHONE"]) ? $phone["PHONE"] : ""; ?>"  />
    <p class="error"></p>
  </div>

  <input type="submit" id="edit-donor-profile-submit" name="edit-donor-profile-submit" value="submit" />
</form>
<?php include_once("../templates/footer.php");