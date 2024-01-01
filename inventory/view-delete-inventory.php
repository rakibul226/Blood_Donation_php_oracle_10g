<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  if(!(isset($_SESSION["user_type"]) && ($_SESSION["user_type"] == "executive" || $_SESSION["user_type"] == "bloodbank"))) {
    echo "You are not allowed!!!<br> <a href=\"../common/dashboard.php\">Dashboard</a>";
    session_abort();
    exit();
  }
?>
<?php
  $title = "View Inventory";
  
  require_once("../database.php");
  $inventories = Database::get("SELECT * FROM INVENTORY_VIEW");
//   echo "<pre>";
//   var_dump($inventorys);
//   echo "</pre>";
?>
<?php include_once("../templates/header.php"); ?>
<header>
  <h1>Manage Inventory</h1>
</header>
<main>
  <table>
    <thead>
      <tr>
        <th>Name</th>
        <th>Address</th>
        <th>Blood Group</th>
        <th>Amount</th>
        <th>Phone</th>

        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($inventories as $inventory): ?>
        <tr>
          <td><?php echo $inventory["name"] ?></td>
          <td><?php echo $inventory["address"] ?></td>
          <td><?php echo $inventory["bloodgroup"] ?></td>
          <td><?php echo $inventory["amount"] ?></td>
          <td><?php echo $inventory["phone"] ?></td>
          <td>
            
            <a href="delete-inventory.php?id=<?php echo $inventory["id"]; ?>">Delete</a>
            <a href="manage-inventory.php?id=<?php echo $inventory["id"]; ?>">Modify</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php");