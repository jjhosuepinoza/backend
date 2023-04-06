<?php

//Model for vehicle inventory imagae uploads//

// Add image information to the database table
function storeImages($imgPath, $invId, $imgName, $imgPrimary) {
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO images (invId, imgPath, imgName, imgPrimary) VALUES (:invId, :imgPath, :imgName, :imgPrimary)';
    $stmt = $db->prepare($sql);
    // Store the full size image information
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_STR);
    $stmt->execute();
        
    // Make and store the thumbnail image information
    // Change name in path
    $imgPath = makeThumbnailName($imgPath);
    // Change name in file name
    $imgName = makeThumbnailName($imgName);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_STR);
    $stmt->execute();
    
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

   // Get Image Information from images table
function getImages() {
    $db = phpmotorsConnect();
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel FROM images JOIN inventory ON images.invId = inventory.invId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
   }

   // Delete image information from the images table
function deleteImage($imgId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
   }

   // Check for an existing image
function checkExistingImage($imgName){
    $db = phpmotorsConnect();
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
   }

   function getThumbnailImages($vehicleId){
    $db = phpmotorsConnect();
    $sql = 'SELECT images.imgPath FROM images INNER JOIN inventory on inventory.invId = images.invId AND inventory.invId = :invId AND images.imgPath LIKE "%tn%"';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $vehicleId, PDO::PARAM_STR);
    $stmt->execute();
    $thumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $thumbnails;
}

?>