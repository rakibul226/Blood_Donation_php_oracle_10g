
<?php
$title = "New Patient";
$result = null;


if (isset($_POST["new-patient-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN INSERT_PATIENT(:p_name, :p_email, :p_gender, :p_address, :p_bloodgroup, :ph_number);END;",
    [
      ":p_name" => $_POST["name"],
      ":p_email" => $_POST["email"],
      ":p_gender" => $_POST["gender"],
      ":p_address" => $_POST["address"],
      ":p_bloodgroup" => $_POST["blood_group"],
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
<h1>Register New Patient</h1>
</header>
<form method="post">

  <label for="name">Name: </label>
  <div>
    <input type="text" name="name" id="name" />
    <p class="error"></p>
  </div>

  <label for="email">Email: </label>
  <div>
    <input type="text" name="email" id="email" />
    <p class="error"></p>
  </div>


  <label for="male">Gender: </label>
  <div>
    <span>
      <input type="radio" name="gender" id="male" value="male" />
      <label for="male">Male</label>
      <input type="radio" name="gender" id="female" value="female" />
      <label for="female">Female</label>
      <input type="radio" name="gender" id="other" value="other" />
      <label for="other">Other</label>
    </span>
    <p class="error"></p>
  </div>

  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" />
    <p class="error"></p>
  </div>


  <label for="blood_group">Blood Group: </label>
  <div>
    <select name="blood_group" id="blood_group">
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
  <label for="phone">Phone: </label>
  <div>
    <input type="text" name="phone" id="phone" />
    <p class="error"></p>
  </div>

  <input type="submit" id="new-patient-submit" name="new-patient-submit" value="submit" />


</form>
<?php include_once("../templates/footer.php");