<?php
$title = "Upcomig Blood Bank";
$result = null;


if (isset($_POST["branch_name"])) {
  require_once("../database.php");
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";
  // exit();

  $result = Database::execute(
    "INSERT INTO BLOODBANK(BB_ID, BB_NAME, BB_ADDRESS, PHONE_ID) VALUES(:bb_id, :bb_name, :bb_address, :ph_id)",
    [
      ":bb_id" => $_POST["branch_id"],
      ":bb_name" => $_POST["branch_name"],
      ":bb_address" => $_POST["address"],
      ":ph_id" => $_POST["phone_id"]

    ]
  );


  // echo "<pre>";
  // var_dump($result);
  // echo "</pre>";
}

?>
<?php include_once("../templates/header.php"); ?>

<form method="post">
  <label for="branch_name">Branch Name: </label>
  <div>
    <input type="text" name="branch_name" id="branch_name" />
    <p class="error"></p>
  </div>
  <label for="branch_id">Branch Id: </label>
  <div>
    <input type="text" name="branch_id" id="branch_id" />
    <p class="error"></p>
  </div>

  <label for="address">Address: </label>
  <div>
    <input type="text" name="address" id="address" />
    <p class="error"></p>
  </div>
  <label for="phone_id">Phone Id: </label>
  <div>
    <input type="text" name="phone_id" id="phone_id" />
    <p class="error"></p>
  </div>

  <input type="submit" id="new-blood-bank-submit" value="submit" />
</form>

<?php include_once("../templates/footer.php");