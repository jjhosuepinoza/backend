<?php if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Image Management | PHP Motors</title>
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
        <h1>Image Management</h1>
        <p>Welcome to the Image Management </p>

        <h2>Add New Vehicle Image</h2>
<div style="color: dodgerblue;" >
<?php 
 if (isset($message)) {
  echo $message;
 } ?>
 </div>

<form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data" id="space-form">
 <label for="invItem">Vehicle</label><br>
	<?php echo $prodSelect; ?> 
	<fieldset >
		<label>Is this the main image for the vehicle?</label>
		<label for="priYes" class="pImage">Yes</label>
		<input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
		<label for="priNo" class="pImage">No</label>
		<input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
	</fieldset>
 <label>Upload Image:</label>
 <input type="file" name="file1">
 <input type="submit" class="regbtn" id ="regbtn" value="Upload">
 <input type="hidden" name="action" value="upload">
</form>

<hr>

<h2>Existing Images</h2>
<p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
<?php
 if (isset($imageDisplay)) {
  echo $imageDisplay;
 } ?>
      <hr>
      </main>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html><?php unset($_SESSION['message']); ?>