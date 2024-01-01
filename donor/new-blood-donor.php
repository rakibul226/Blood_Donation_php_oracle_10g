
<?php
$title = "New Donor";
$result = null;


if (isset($_POST["new-blood-donor-submit"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "BEGIN INSERT_DONOR(:d_name, :d_email,:d_gender,:d_age, :d_bloodgroup, :d_address, :ph_number);END;",
    [
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
<header>
<h1>Register New Donor</h1>
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

  <label for="age">Age: </label>
  <div>
    <input type="text" name="age" id="age" />
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

  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" />
    <p class="error"></p>
  </div>

  <label for="phone">Phone: </label>
  <div>
    <input type="text" name="phone" id="phone" />
    <p class="error"></p>
  </div>

  <input type="submit" id="new-blood-donor-submit" name="new-blood-donor-submit" value="submit" />
</form>

<?php include_once("../templates/footer.php");