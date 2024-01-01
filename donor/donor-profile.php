<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "donor")) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
if (isset($_SESSION['user_email']) && !empty($_SESSION['user_email'])) {
    require_once("../database.php");
    
    $donor = Database::get("SELECT * FROM DONOR WHERE d_email = :d_email ", [":d_email" => $_SESSION['user_email'],] );

    if(count($donor) > 0) {
      $donor = $donor[0];
    }

    // echo "<pre>";
    // var_dump($donor);
    // echo "</pre>";
    // exit();
}
?>
<?php include_once("../templates/header.php"); ?>
<header>
  <h1>View Donor Profile</h1>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th>Donor Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Blood Group</th>
        <th>Address</th>
        <th>Phone</th>

        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($donor)): ?>
        <tr>
          <td><?php echo isset($donor["D_ID"]) ? $donor["D_ID"] : ""; ?></td>
          <td><?php echo isset($donor["D_NAME"]) ? $donor["D_NAME"] : ""; ?></td>
          <td><?php echo isset($donor["D_EMAIL"]) ? $donor["D_EMAIL"] : ""; ?></td>
          <td><?php echo isset($donor["D_GENDER"]) ? $donor["D_GENDER"] : ""; ?></td>
          <td><?php echo isset($donor["D_AGE"]) ? $donor["D_AGE"] : ""; ?></td>
          <td><?php echo isset($donor["D_BLOODGROUP"]) ? $donor["D_BLOODGROUP"] : ""; ?></td>
          <td><?php echo isset($donor["D_ADDRESS"]) ? $donor["D_ADDRESS"] : ""; ?></td>
          <td><?php echo isset($donor["PH_ID"]) ? $donor["PH_ID"] : ""; ?></td>
          <td>
          <a href="edit-donor-profile.php?id=<?php echo isset($donor["D_ID"]) ? $donor["D_ID"] : ""; ?>">Modify</a>
          </td>
        </tr>
      <?php else: ?>
        <tr>
          <td colspan="8">Donor not found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php"); ?>
