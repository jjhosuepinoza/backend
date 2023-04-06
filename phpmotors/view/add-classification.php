<?php
 // Filter the user
if(!($_SESSION['loggedin']&&($_SESSION['clientData']['clientLevel']>1))){
  header('Location: /phpmotors');
  exit;
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
      <nav>
        <?php  //include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/nav.php";
        echo $navList; ?>
      </nav>
    </header>
    
    <main>
    <h1>Add Car Classification</h1>
      <div id="error-message" style="color: brown;">
      <?php
      if (isset($errorMessage)) {
        echo $errorMessage;
      }
      ?>
      </div>
      <?php
      if (isset($message)) {
        echo $message;
      }
      ?>
    
        <form method="post" action="/phpmotors/vehicles/index.php">
          <label for ="classificationName" class="" style="font-weight:bold; font-size:medium;">Classification Name</label><br>
          <span id = "pass-label" style="font-size: smaller;"> It can not be higher than 30 characters</span>
            <input type="text" name="classificationName" id="classificationName"<?php if(isset($classificationName)){echo "value='$classificationName'";} ?> required>
          <input type="submit" value="Add Classification" id="regbtn">
          <input type="hidden" name="action" value="registerClassification">
        </form>
     
    </main>
    <hr>
    <footer>
      <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
    </footer>
  </div>
</body>

</html>