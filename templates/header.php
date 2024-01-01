<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    <?php echo $title ?? ""; ?>
  </title>
  <link rel="stylesheet" href="../styles.css" />
</head>

<body>
  <nav>
    <ul>
      <li><a href="../index.php">Home Page</a></li>
      <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true" && isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "executive"): ?>

        <li><a href="../bloodrequest/view-manage-blood-request.php">*View Blood Request*</a></li>               
        <!-- <li><a href="../bloodrequest/blood-request.php">Make Blood Request</a></li>                -->
        <!-- <li><a href="../patient/new-patient.php">Register New Patient</a></li> -->
        <li><a href="../patient/view-patient.php">*View Patient* </a></li>
        <li><a href="../patient/view-manage-patient.php">*Manage Patient* </a></li>
        <!-- <li><a href="../donor/new-blood-donor.php">Register New Donor</a></li> -->
        <li><a href="../donor/view-donor.php">*View Donor*</a></li>
        <li><a href="../donor/manage-donor.php">*Manage Donor*</a></li>
        <li><a href="../inventory/add-inventory.php">*Add New Inventory*</a></li>
        <li><a href="../inventory/view-inventory.php">*View Inventory*</a></li>
        <li><a href="../inventory/view-delete-inventory.php">*Manage Inventory*</a></li>
        
      <?php endif; ?>
      <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true" && (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "patient")): ?>

        <li><a href="../bloodrequest/blood-request.php">*Make Blood Request*</a></li>
        <li><a href="../inventory/view-inventory.php">*View Inventory*</a></li>
        <li><a href="../donor/view-donor.php">*View Donor*</a></li>
        <li><a href="../patient/patient-profile.php">*View Profile*</a></li>


      <?php endif; ?>

      <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true" && (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "donor")): ?>

        <li><a href="../bloodrequest/view-blood-request.php">*View Blood Request*</a></li>  
        <li><a href="../patient/view-patient.php">*View Patient* </a></li>             
        <li><a href="../inventory/view-inventory.php">*View Inventory*</a></li>
        <li><a href="../donor/donor-profile.php">*View Profile*</a></li>


      <?php endif; ?>

      <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true" && (isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "bloodbank")): ?>

        <li><a href="../donor/view-donor.php">*View Donor*</a></li>
        <li><a href="../bloodrequest/view-blood-request.php">*View Blood Request*</a></li>  
        <li><a href="../inventory/add-inventory.php">*Add New Inventory*</a></li>
        <li><a href="../inventory/view-delete-inventory.php">*Manage Inventory*</a></li>
        <li><a href="../inventory/view-inventory.php">*View Inventory*</a></li>
        <li><a href="../patient/view-patient.php">*View Patient* </a></li>             

      <?php endif; ?>
      <?Php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "true"): ?>
        <li><a href="../common/logout.php">Logout</a></li>
      <?php endif; ?>

    </ul>
  </nav>
  <div class="main">