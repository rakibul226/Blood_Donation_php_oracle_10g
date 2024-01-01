<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "executive"))) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
  $title = "View Donor";
  
  require_once("../database.php");
  $donors = Database::get("SELECT * FROM DONOR_VIEW");
  // echo "<pre>";
  // var_dump($patients);
  // echo "</pre>";
?>
<?php include_once("../templates/header.php"); ?>
<header>
  <h1>Manage Donor</h1>
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
      <?php foreach ($donors as $donor): ?>
        <tr>
          <td><?php echo $donor["id"] ?></td>
          <td><?php echo $donor["name"] ?></td>
          <td><?php echo $donor["email"] ?></td>
          <td><?php echo $donor["gender"] ?></td>
          <td><?php echo $donor["age"] ?></td>
          <td><?php echo $donor["bloodgroup"] ?></td>
          <td><?php echo $donor["address"] ?></td>
          <td><?php echo $donor["phone"] ?></td>

         
          <td>
            
            <a href="delete-donor.php?id=<?php echo $donor["id"]; ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php");