<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
    echo " $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)) { 
		echo " $invMake $invModel"; }?></title>
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
      <main id="detailed-view">
     
        <?php if(isset($message)){
            echo $message;
        }
        ?>
        <?php if(isset($vehicleSelectedDisplay)){
            echo $vehicleSelectedDisplay;
        } ?>


<section class='reviews'>
<h2>Customer Reviews</h2>
<?php
if ($_SESSION['loggedin']){
echo "<h3>Review the $invMake $invModell</h3>";
if (isset($_SESSION['message'])) {
echo $_SESSION['message'];
}
echo "<div class='addVehicle'>
<form method='post' action='/phpmotors/reviews/index.php'>
<label>Screen Name: <input type='text' name='screenName' class='name' readonly value='";
if(isset($screenName)) { echo $screenName; } elseif (isset($screenNameSes)) { echo $screenNameSes; };
echo "'></label>
<label>Review<textarea name='reviewText' required></textarea></label>
<input type='submit' name='submit' value='Submit Review' class='submitBtn'>
<input type='hidden' name='action' value='addReview'>
<input type='hidden' name='invId' value='$invId'>
</form>
</div>";
}else{
echo '<p>You must <a href="/phpmotors/accounts?action=login"> login</a> to write a review.</p>';
}
?>
<!-- Display reviews if they exist or prompt to add the first review -->
<div><?php if(isset($vehicleReviewDisplay)){

echo $vehicleReviewDisplay;
}else{
echo "<p><em>Be the first to write a review.</em></p>";
} ?>
</div>
</section>

    </main>
      <hr>
      <footer>
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/phpmotors/common/footer.php" ?>
      </footer>
    </div>
  </body>
</html>