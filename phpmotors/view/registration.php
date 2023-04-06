<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Content Title | PHP Motors</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/css/style.css" type="text/css" rel="stylesheet" media="screen">
    <!-- <script>    
function myFunction() {
  var x = document.getElementById("psw");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script> -->
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
        <h1>REGISTER</h1> 
        <p> All fields are required</p>
<?php
if (isset($message)) {
 echo $message;
}
?>


<form action="/phpmotors/accounts/index.php" method="post">
        
        <label for="clientFirstname"><b>First Name</b></label><br>
       <input type="text" placeholder="Enter First Name" id="clientFirstname" name="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required><br>
       <label for="clientLastname"><b>Last Name</b></label><br>
       <input type="text" placeholder="Enter Last Name" id="clientLastname" name="clientLastname"<?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required><br>
       <label for="clientEmail"><b>Email</b></label><br>
       <input type="email" placeholder="Enter Email" id="clientEmail"  name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br>
        <label for="clientPassword"><b>Password</b></label><br>
        <span id = "pass-label">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <input type="password" placeholder="Enter Password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" title="Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character" required><br>
        <!-- <label>
        <input type="checkbox" onclick="myFunction()" id="showpsw" name="showpsw">Show Password<br>
        </label> -->
        
       <input type="submit" name="submit" id="regbtn" value="Register">
        <input type="hidden" name="action" value="register"> 
   
</form>
      </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>