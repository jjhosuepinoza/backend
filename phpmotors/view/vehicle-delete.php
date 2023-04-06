<?php
 //Check the type of user
if($_SESSION['clientData']['clientLevel'] < 2){
 header('location: /phpmotors/');
 exit;
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
  <title><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?>Delete | PHP Motors</title>
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
      <h1><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1>
    
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
<p>Confirm Vehicle Deletion. The delete is permanent.</p>

<form method="post" action="/phpmotors/vehicles/">
<fieldset>
	<label for="invMake">Vehicle Make</label>
	<input type="text" readonly name="invMake" id="invMake" <?php
if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>

	<label for="invModel">Vehicle Model</label>
	<input type="text" readonly name="invModel" id="invModel" <?php
if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>

	<label for="invDescription">Vehicle Description</label>
	<textarea name="invDescription" readonly id="invDescription" style="resize: none; width: 100%; height: 200px;"><?php
if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }
?></textarea>

<input type="submit" class="regbtn" name="submit" id="regbtn"value="Delete Vehicle">

	<input type="hidden" name="action" value="deleteVehicle">
	<input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
echo $invInfo['invId'];} ?>">

</fieldset>
</form>

    </main>
        <hr>
        <footer>
          <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
        </footer>
  </div>
</body>

</html>