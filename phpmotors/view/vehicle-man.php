<?php
 // Filter the user
 if ($_SESSION['clientData']['clientLevel'] < 2) {
  header('location: /phpmotors/');
  exit;
 }
 if (isset($_SESSION['message'])) {
  $message = $_SESSION['message'];
 }
 
// if ($_SESSION['clientData']['clientLevel'] < 2) {
//   header('location: /phpmotors/');
//   exit;
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Content Title | PHP Motors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div id="wrapper">
      <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/header.php" ?>
      </header>
      <nav>
      <?php  //include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/nav.php";
         echo $navList; ?>  
      </nav>
      <main>
        
        <h1>Vehicle Management</h1>
        <div style="color: dodgerblue;">
        <?php
if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>
</div>

<div >
        <ul id="vehmanage">

     
  <button   onclick="location.href='../vehicles/index.php/?action=classification-page'">Add Classification</button><br>
  <button  onclick="location.href='../vehicles/index.php/?action=vehicle-page'">Add Vehicle</button><br>
  <button   onclick="location.href='../uploads/index.php'">Upload Images </button>

    </ul>
    
</div>


    <?php
if (isset($message)) { 
 echo $message; 
} 
if (isset($classificationList)) { 
 echo '<h2>Vehicles By Classification</h2>'; 
 echo '<p>Choose a classification to see those vehicles</p>'; 
 echo $classificationList; 
}
?>

<noscript>
<p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
</noscript>



<table id="inventoryDisplay"></table>
      </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>

    <script src="../js/inventory.js"></script>
  </body>
</html><?php unset($_SESSION['message']); ?>