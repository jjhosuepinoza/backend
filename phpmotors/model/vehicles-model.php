<?php // Vehicles Model
// Insert a new vehicle to the inventory table 
function insVehicle($classificationId, $invMake, $invModel, $invDescription,
$invImage, $invThumbnail, $invPrice, $invStock, $invColor){
$db = phpmotorsConnect();
// Create a connection object using the phpmotors connection function // The SQL statement
$sql = 'INSERT INTO inventory (classificationId, invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor)
VALUES (:classificationId, :invMake, :invModel, :invDescription,:invImage, :invThumbnail, :invPrice, :invStock, :invColor)';
// Create the prepared statement using the phpmotors connection
$stmt = $db->prepare($sql);
// The next nine lines replace the placeholders in the sql
$stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_STR);
$stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
$stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
$stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
$stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
$stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
$stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
$stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
$stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
// Insert the data
$stmt->execute();
// Ask how many rows changed as a result of our insert 
$rowsChanged = $stmt->rowCount();
// Close the database interaction 
$stmt->closeCursor();
// Return the indication of success (rows changed)
return $rowsChanged;
}

// Insert a new classification to the carclassification table
function insClassification ($classificationName) { 
// Create a connection object using the phpmotors connection function
$db = phpmotorsConnect(); 
// The SQL statement
$sql = 'INSERT INTO carclassification (classificationName)
         VALUES (:classificationName)';
// Create the prepared statement using the phpmotors connection 
$stmt = $db->prepare($sql);
// The next lines replace the placeholders in the SQL
// statement with the actual values in the variables // and tells the database the type of data it is
$stmt->bindValue(':classificationName', $classificationName, PDO:: PARAM_STR);
// Insert the data
$stmt->execute();
// Ask how many rows changed as a result of our insert
$rowsChanged = $stmt->rowCount();
// Close the database interaction
$stmt->closeCursor();
// Return the indication of success (rows changed)
return $rowsChanged;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
   }

 // Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    //Douting the change from int to str
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }

   // Update a vehicle
	function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor,
	$classificationId, $invId) {
  $db = phpmotorsConnect();
  $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
  $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
   $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
  $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
  $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
  $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
  $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
  $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
  $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
}

//Delete a vehicle
function deleteVehicle($invId) {
  $db = phpmotorsConnect();
  $sql = 'DELETE FROM inventory WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
  $stmt->execute();
  $rowsChanged = $stmt->rowCount();
  $stmt->closeCursor();
  return $rowsChanged;
 }


 //Get lists of vechicles by classification name
 function getVehiclesByClassification($classificationName){
  $db = phpmotorsConnect();
  $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
  $stmt->execute();
  $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $vehicles;
 }

 function getVehicleDetailInfo($vehicleId){
  $db = phpmotorsConnect();
  $sql = 'SELECT * FROM inventory WHERE invId = :invId';

  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $vehicleId, PDO::PARAM_STR);
  $stmt->execute();
  $vehicleSelected = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $vehicleSelected;
}


// Get information for all vehicles
function getVehicles(){
	$db = phpmotorsConnect();
	$sql = 'SELECT invId, invMake, invModel FROM inventory';
	$stmt = $db->prepare($sql);
	$stmt->execute();
	$invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $invInfo;
}


?>