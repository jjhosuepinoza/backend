<?php
 //Check the type of user
 if($_SESSION['loggedin'] != TRUE || $_SESSION['clientData']['clientLevel'] < 2) { 
  header("Location: ../");
 }

 // Build the select list
$classificationList = "<option value=''>Choose car classification</option>"; 
foreach ($classifications as $classification) {
  $classificationList .= "<option value='$classification[classificationId]'";
  if (isset($classificationId)){
    if ($classification['classificationId'] == $classificationId) {
$classificationList .= ' selected ';
}
} elseif(isset($invInfo['classificationId'])){
  if($classification['classificationId'] === $invInfo['classificationId']){
      $classificationList .= ' selected ';
  }
}
$classificationList .= ">$classification[classificationName]</option>>";
};
?><!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
    echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?>Add Vehicle | PHP Motors</title>
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
      <h1><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
		echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo "Modify $invMake $invModel"; }?></h1>
    
      <div style="color:brown; font-weight:bold;" >
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
<p>*Note all Fields are Required</p>

<form method="post" action="/phpmotors/vehicles/index.php">
  <label for="classificationId">Classification:</label>
  <select name="classificationId" id="classificationId" style="width: 100%; height:40px; font-size:15px;">
    <?php echo $classificationList; ?>
  </select><br>

  <label for="invMake">Make:</label>
  <input type="text" name="invMake" id="invMake" <?php if(isset($invMake)){echo "value='$invMake'";} elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> required><br>

  <label for="invModel">Model:</label>
  <input type="text" name="invModel" id="invModel" <?php if(isset($invModel)){echo "value='$invModel'";}elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> required><br>

  <label for="invDescription">Description:</label><br>
  <textarea name="invDescription" id="invDescription" style="resize: none; width: 100%; height: 200px;"  required><?php if(isset($invDescription)){echo $invDescription;} elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; } ?></textarea><br>

  <label for="invImage">Image Path:</label>
  <input type="text" name="invImage" id="invImage" placeholder="/phpmotors/images/vehicles/no-image.png" <?php if(isset($invImage)){echo "value='$invImage'";}elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; } ?> required><br>

  <label for="invThumbnail">Thumbnail Path:</label>
  <input type="text" name="invThumbnail" placeholder="/phpmotors/images/vehicles/no-image.png" id="invThumbnail" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?> required><br>

  <label for="invPrice">Price:</label><br>
  <input type="number" name="invPrice" id="invPrice" min="0"  <?php if(isset($invPrice)){echo "value='$invPrice'";} elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; } ?> required><br>

  <label for="invStock"># In Stock:</label><br>
  <input type="number" name="invStock" id="invStock" min="0"  <?php if(isset($invStock)){echo "value='$invStock'";}elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; } ?> required><br>

  <label for="invColor">Color:</label>
  <input type="text" name="invColor" id="invColor" <?php if(isset($invColor)){echo "value='$invColor'";} elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?> required><br>

  <input type="submit" name="submit" value="Update Vehicle" class="submitBtn"  id="regbtn">
  <input type="hidden" name="action" value="updateVehicle">
<input type="hidden" name ="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
elseif(isset($invId)){ echo $invId; } ?>">

</form>

    </main>
        <hr>
        <footer>
          <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
        </footer>
  </div>
</body>

</html>