
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Sign in | PHP Motors</title>
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
      echo $navList; 
      ?> 
      </nav>
      <main>
        <h1>SIGN IN</h1>
        
<?php
if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
 }
?>
<?php
if (isset($message)) {
echo $message;
}
?>
        <form action="/phpmotors/accounts/" method="post">
        
        <label for="clientEmail"><b>Email</b></label><br>
       <input type="email" placeholder="Enter Email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br>

        <label for="clientPassword"><b>Password</b></label><br>
        <span id = "pass-label">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <input type="password" placeholder="Enter Password" id="clientPassword"  name="clientPassword" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required><br>
        
       <input type="submit" id="signinbtn" value="Sign in"><br>
       <input type="hidden" name="action" value="Login">
     <span class="psw"> <a href = "../accounts/index.php/?action=register-page">Not a member yet?</a></span>

       </form>
      </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>