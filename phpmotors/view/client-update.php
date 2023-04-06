<?php
    if(!isset($_SESSION['loggedin'])){
        header('Location: /phpmotors');
    }
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
      <?php
      echo $navList; ?>
    </nav>
    <main>
      <h1>MANAGE ACCOUNT</h1>
      <p>Update Account</p>
      <div style="color:crimson; font-weight:bold;" >
     <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
      </div>


      <form action="/phpmotors/accounts/index.php" method="post">

        <label for="clientFirstname"><b>First Name</b></label><br>
        <input type="text" placeholder="Enter First Name" id="clientFirstname" name="clientFirstname"   <?php if(isset($_SESSION['clientData']['clientFirstname'])) {echo "value=".$_SESSION['clientData']['clientFirstname']; } ?> required><br>
        <label for="clientLastname"><b>Last Name</b></label><br>
        <input type="text" placeholder="Enter Last Name" id="clientLastname"  name="clientLastname"    <?php if(isset($_SESSION['clientData']['clientLastname'])) {echo "value=".$_SESSION['clientData']['clientLastname']; } ?> required ><br>
        <label for="clientEmail"><b>Email</b></label><br>
        <input type="email" placeholder="Enter Email" id="clientEmail"  required name="clientEmail" <?php if(isset($_SESSION['clientData']['clientEmail'])) {echo "value=".$_SESSION['clientData']['clientEmail']; } ?>><br>
        
        <!-- <label>
        <input type="checkbox" onclick="myFunction()" id="showpsw" name="showpsw">Show Password<br>
        </label> -->

        <input type="submit" name="submit" id="regbtn" value="Update Account">
        <input type="hidden" name="action" value="updateInformation">
        <input type="hidden" name="clientId" value="<?php 
            if(isset($_SESSION['clientData'])){ echo $_SESSION['clientData']['clientId'];} ?>">

      </form>

      <h2>Update Password</h2>
      <div style="color:crimson; font-weight:bold;" >
      <?php 
      if (isset($passMessage)) {
        echo $passMessage;
      }
      ?>
      </div>
      <form action="/phpmotors/accounts/index.php" method="post">
    
      <label for="clientPassword"><b>Password</b></label><br>
        <span id="pass-label">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <input type="password" placeholder="Enter Password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character" required><br>
        
        <input type="submit" name="submit" id="regbtn" value="Update Passsword">
        <input type="hidden" name="action" value="newPassword">
        <input type="hidden" name="clientId" value="<?php 
            if(isset($_SESSION['clientData'])){ echo $_SESSION['clientData']['clientId'];} ?>">
      </form>
    </main>
    <hr>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
    </footer>
  </div>
</body>

</html>