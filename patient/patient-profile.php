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
if (isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])) {
    require_once("../database.php");
    
    $patient = Database::get("SELECT * FROM PATIENT WHERE p_email = :p_email ", [":p_email" => $_SESSION['user_email'],] );

    if(count($patient) > 0) {
      $patient = $patient[0];
    }

    // echo "<pre>";
    // var_dump($patient);
    // echo "</pre>";
    // exit();
}
?>
<?php include_once("../templates/header.php"); ?>
<header>
  <h1>View Patient Profile</h1>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th>Patient Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Blood Group</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($patient)): ?>
        <tr>
          <td><?php echo isset($patient["P_ID"]) ? $patient["P_ID"] : ""; ?></td>
          <td><?php echo isset($patient["P_NAME"]) ? $patient["P_NAME"] : ""; ?></td>
          <td><?php echo isset($patient["P_EMAIL"]) ? $patient["P_EMAIL"] : ""; ?></td>
          <td><?php echo isset($patient["P_GENDER"]) ? $patient["P_GENDER"] : ""; ?></td>
          <td><?php echo isset($patient["PH_ID"]) ? $patient["PH_ID"] : ""; ?></td>
          <td><?php echo isset($patient["P_ADDRESS"]) ? $patient["P_ADDRESS"] : ""; ?></td>
          <td><?php echo isset($patient["P_BLOODGROUP"]) ? $patient["P_BLOODGROUP"] : ""; ?></td>
          <td>
            <a href="edit-patient-profile.php?id=<?php echo isset($patient["P_ID"]) ? $patient["P_ID"] : ""; ?>">Modify</a>
          </td>
        </tr>
      <?php else: ?>
        <tr>
          <td colspan="8">Patient not found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php"); ?>
