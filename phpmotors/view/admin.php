<?php
if (!isset($_SESSION['loggedin'])) {
  header('Location: /phpmotors/accounts/');
};
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
      <h1><?php echo $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname']; ?></h1>
     
      <div style="color:crimson; font-weight:bold;" >
     <?php
if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>
      </div>
     
     <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      <ul>
        <li>First name: <?php echo $_SESSION['clientData']['clientFirstname']; ?></li>
        <li>Last name: <?php echo $_SESSION['clientData']['clientLastname']; ?></li>
        <li>Email: <?php echo $_SESSION['clientData']['clientEmail']; ?></li>
      </ul>
<div id="vehmanage">
<h2>Account Management</h2>
            <p>Use this link to update account information</p>
            <button   onclick="location.href='../accounts/?action=manageAccount'">Update Account Information</button>
</div>


<div>
<?php
  $clientLevel = $_SESSION['clientData']['clientLevel'];
  if ($clientLevel > 1) {
    echo "<div id=\"vehmanage\">
              <h2>Inventory Management</h2>
              <p>Use this link to manage the inventory.</p>
              <button onclick=\"location.href='../vehicles'\">Vehicle Management</button>
          </div>";
  }
?>
</div>

<h3>Your Reviews</h3>
<?php if (isset($reviewHTML)) echo $reviewHTML; ?>

    </main>
    <hr>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
    </footer>
  </div>
</body>

</html>