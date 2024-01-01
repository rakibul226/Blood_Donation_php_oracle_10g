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
  <h1>View Inventory</h1>
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

        <!-- <th>Action</th> -->
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
          <!-- <td> -->
            
            <!-- <a href="delete-patient.php?id=<?php echo $inventory["id"]; ?>">Delete</a> -->
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>
<?php include_once("../templates/footer.php");