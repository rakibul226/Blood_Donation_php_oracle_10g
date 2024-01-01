<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && $_SESSION["user_type"] == "executive"|| $_SESSION["user_type"] == "bloodbank")) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
  $title = "View Blood Request";
  
  require_once("../database.php");
  $bloodrequests = Database::get("SELECT * FROM BLOODREQUEST_VIEW");
  // echo "<pre>";
  // var_dump($patients);
  // echo "</pre>";
?>
<?php include_once("../templates/header.php"); ?>
<header>
  <h1>View Blood Request</h1>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th>Blood Request Id</th>
        <th>Patient Name</th>
        <th>Patient Email</th>
        <th>Blood Group</th>
        <th>Amount</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bloodrequests as $bloodrequest): ?>
        <tr>
          <td><?php echo $bloodrequest["id"] ?></td>
          <td><?php echo $bloodrequest["bloodrequester_name"] ?></td>
          <td><?php echo $bloodrequest["bloodrequester_email"] ?></td>
          <td><?php echo $bloodrequest["bloodgroup"] ?></td>
          <td><?php echo $bloodrequest["amount"] ?></td>
          <td>
            
            <a href="delete-blood-request.php?id=<?php echo $bloodrequest["id"]; ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php");