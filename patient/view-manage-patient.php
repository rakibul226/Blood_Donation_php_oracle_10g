<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "executive")) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
  $title = "View Patient";
  
  require_once("../database.php");
  $patients = Database::get("SELECT * FROM PATIENT_VIEW");
  // echo "<pre>";
  // var_dump($patients);
  // echo "</pre>";
?>
<?php include_once("../templates/header.php"); ?>
<header>
  <h1>View Patient</h1>
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
      <?php foreach ($patients as $patient): ?>
        <tr>
          <td><?php echo $patient["id"] ?></td>
          <td><?php echo $patient["name"] ?></td>
          <td><?php echo $patient["email"] ?></td>
          <td><?php echo $patient["gender"] ?></td>
          <td><?php echo $patient["phone"] ?></td>
          <td><?php echo $patient["address"] ?></td>
          <td><?php echo $patient["bloodgroup"] ?></td>
          <td>
            
            <a href="delete-patient.php?id=<?php echo $patient["id"]; ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php");