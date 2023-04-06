<?php
function checkEmail($clientEmail){
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}
// Check the password for a minimum of 8 characters,
 // at least one 1 capital letter, at least 1 number and
 // at least 1 special character
 function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
   }
   //Check the classification name maximun 30 characters
   // function checkClassification($classificationName){
   //    $pattern = '/^(?:.({1,30})$/';
   //    return preg_match($pattern, $classificationName);
   // }
//Creates navbar
function navBuild($classifications){
   $navList = '<ul>';
   $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
   foreach ($classifications as $classification) {
      $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
   }
   $navList .= '</ul>';
   return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
   $classificationList = '<select name="classificationId" id="classificationList">'; 
   $classificationList .= "<option>Choose a Classification</option>"; 
   foreach ($classifications as $classification) { 
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
   } 
   $classificationList .= '</select>'; 
   return $classificationList; 
  }

  //Wrap vehicles by calssification in a list
  function buildVehiclesDisplay($vehicles){
   $dv = '<ul id="inv-display">';
   foreach ($vehicles as $vehicle){
   $dv .= '<li>';
   $dv .= "<a href='/phpmotors/vehicles/index.php?action=vehicleFeatures&vehicleId=$vehicle[invId]'><img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
   
   $dv .= '<hr>';
   $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
   $dv .= "<p> $<span>" . number_format($vehicle['invPrice'], 0, '.', ',') . "</span></p> </a> ";
   $dv .= '</li>';
   }
   $dv .= '</ul>';
   return $dv;
  }

// function buildVehiclesDisplay($vehicles){
//    $dv = '<ul id="inv-display">';
//    foreach ($vehicles as $vehicle){
//        $dv .= '<li>';
//        $dv .= "<a href='/phpmotors/vehicles/index.php?action=vehicleFeatures&vehicleId={$vehicle['invId']}'><img src='{$vehicle['invThumbnail']}' alt='Image of {$vehicle['invMake']} {$vehicle['invModel']} on phpmotors.com'>";
//        $dv .= '<hr>';
//        $dv .= "<h2>{$vehicle['invMake']} {$vehicle['invModel']}</h2>";
//        $dv .= "<p> $<span>" . number_format($vehicle['invPrice'], 0, '.', ',') . "</span></p> </a> ";
//        $dv .= '</li>';
//    }
//    $dv .= '</ul>';
//    return $dv;
// }

  //Build vehicles in HTML



  function buildVehicleSelectedDisplay($vehicleSelected, $thumbnails){
    
   foreach($vehicleSelected as $vehicleData){
       $dv = "<h1>$vehicleData[invMake] $vehicleData[invModel]</h1>";
       $dv .= "<section id='image-details'>";
       $dv .=  "<aside>";
       foreach($thumbnails as $thumbnail){
       $dv .= "<img class='thumbnail' src='$thumbnail[imgPath]' alt='Image of $vehicleData[invMake] $vehicleData[invModel] on phpmotors.com'>";
     }
      $dv .=  "</aside>";
       $dv .= "<img src='$vehicleData[invImage]' alt='Image of $vehicleData[invMake] $vehicleData[invModel] on phpmotors.com'>";
       $dv .=  "<article>";
       $dv .= "<p>Price: $<span>" . number_format($vehicleData['invPrice'], 0, '.', ',') . "</span></p>";
       $dv .= "<h2>$vehicleData[invMake] $vehicleData[invModel] Detail</h2>";
       $dv .= "<p>$vehicleData[invDescription]</p>";
       $dv .= "<p>Color: <span>$vehicleData[invColor]</span></p>";
       $dv .= "<p># In Stock: <span>$vehicleData[invStock]</span></p>";
       $dv .=  "</article>";
   }
   $dv .= "</section>";
   return $dv;

}

/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image) {
   $i = strrpos($image, '.');
   $image_name = substr($image, 0, $i);
   $ext = substr($image, $i);
   $image = $image_name . '-tn' . $ext;
   return $image;
  }

// Build images display for image management view
function buildImageDisplay($imageArray) {
   $id = '<ul id="image-display">';
   foreach ($imageArray as $image) {
    $id .= '<li>';
    $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
    $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
    $id .= '</li>';
  }
   $id .= '</ul>';
   return $id;
  }

  // Build the vehicles select list
function buildVehiclesSelect($vehicles) {
   $prodList = '<select name="invId" id="invId">';
   $prodList .= "<option>Choose a Vehicle</option>";
   foreach ($vehicles as $vehicle) {
    $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
   }
   $prodList .= '</select>';
   return $prodList;
  }


  // Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
   // Gets the paths, full and local directory
   global $image_dir, $image_dir_path;
   if (isset($_FILES[$name])) {
    // Gets the actual file name
    $filename = $_FILES[$name]['name'];
    if (empty($filename)) {
     return;
    }
   // Get the file from the temp folder on the server
   $source = $_FILES[$name]['tmp_name'];
   // Sets the new path - images folder in this directory
   $target = $image_dir_path . '/' . $filename;
   // Moves the file to the target folder
   move_uploaded_file($source, $target);
   // Send file for further processing
   processImage($image_dir_path, $filename);
   // Sets the path for the image for Database storage
   $filepath = $image_dir . '/' . $filename;
   // Returns the path where the file is stored
   return $filepath;
   }
  }

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
   // Set up the variables
   $dir = $dir . '/';
  
   // Set up the image path
   $image_path = $dir . $filename;
  
   // Set up the thumbnail image path
   $image_path_tn = $dir.makeThumbnailName($filename);
  
   // Create a thumbnail image that's a maximum of 200 pixels square
   resizeImage($image_path, $image_path_tn, 200, 200);
  
   // Resize original to a maximum of 500 pixels square
   resizeImage($image_path, $image_path, 500, 500);
  }

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
   // Get image type
   $image_info = getimagesize($old_image_path);
   $image_type = $image_info[2];
  
   // Set up the function names
   switch ($image_type) {
   case IMAGETYPE_JPEG:
    $image_from_file = 'imagecreatefromjpeg';
    $image_to_file = 'imagejpeg';
   break;
   case IMAGETYPE_GIF:
    $image_from_file = 'imagecreatefromgif';
    $image_to_file = 'imagegif';
   break;
   case IMAGETYPE_PNG:
    $image_from_file = 'imagecreatefrompng';
    $image_to_file = 'imagepng';
   break;
   default:
    return;
  } // ends the swith
  
   // Get the old image and its height and width
   $old_image = $image_from_file($old_image_path);
   $old_width = imagesx($old_image);
   $old_height = imagesy($old_image);
  
   // Calculate height and width ratios
   $width_ratio = $old_width / $max_width;
   $height_ratio = $old_height / $max_height;
  
   // If image is larger than specified ratio, create the new image
   if ($width_ratio > 1 || $height_ratio > 1) {
  
    // Calculate height and width for the new image
    $ratio = max($width_ratio, $height_ratio);
    $new_height = round($old_height / $ratio);
    $new_width = round($old_width / $ratio);
  
    // Create the new image
    $new_image = imagecreatetruecolor($new_width, $new_height);
  
    // Set transparency according to image type
    if ($image_type == IMAGETYPE_GIF) {
     $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
     imagecolortransparent($new_image, $alpha);
    }
  
    if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
     imagealphablending($new_image, false);
     imagesavealpha($new_image, true);
    }
  
    // Copy old image to new image - this resizes the image
    $new_x = 0;
    $new_y = 0;
    $old_x = 0;
    $old_y = 0;
    imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
  
    // Write the new image to a new file
    $image_to_file($new_image, $new_image_path);
    // Free any memory associated with the new image
    imagedestroy($new_image);
    } else {
    // Write the old image to a new file
    $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
  } // ends resizeImage function

//Build review display for vehicle-detail view
function buildReviewDisplay($reviewList){
   $rd = '<ul class="review-display">';
   foreach ($reviewList as $review) {
   $clientFirstname = $review['clientFirstname'];
   $clientLastname = $review['clientLastname'];
   $firstLetter = ucfirst ($clientFirstname[0]);
   $clientLastname = ucfirst ($clientLastname);
   $screenName = "$firstLetter$clientLastname";
   $date = $review['reviewDate'];
   $date = strtotime($date);
   $date = date("j F, Y", $date);
   $rd.= '<li>';
   $rd .= "<p class='review-display'><span class='name'>$screenName</span> wrote on $date:</p><p class='text'>$review[reviewText]</p>";
   $rd.= '</li>';
   }
   $rd.= '</ul>';
   return $rd;
   }
   //Build display of reviews written by a specific client
   function buildClientReviewsDisplay($reviewList){
   $rd = '<ul class="clientReview-display">';
   
   foreach ($reviewList as $review) {
   $date = $review['reviewDate']; 
   $date = strtotime($date);
   $date = date("j F, Y", $date);
   $rd .= '<li>';
   $rd .= "$review[invMake] $review [invModel] (Reviewed on $date): <a href='/phpmotors/reviews?action=edit&reviewId=$review[reviewId] '>Edit</a> | <a href='/phpmotors/reviews?action=delete'>Delete</a>";
   $rd .= '</li>';
   }
   $rd .= '</ul>';
   return $rd;
   }
   
   function buildEditView($review) {
       $date = $review['reviewDate'];
       $date = strtotime($date);
       $date = date("j F, Y", $date);
       $ed = "<h1>{$review['invMake']} {$review['invModel']} Review</h1>";
       $ed .= "<p>Reviewed on $date</p>";
       if (isset($_SESSION['message'])) {
           $ed .= "<p>{$_SESSION['message']}</p>";
       }
       $ed .= "<div class='addVehicle'>
           <form method='post' action='/phpmotors/reviews/index.php'>
               <label>Review Text<textarea name='reviewText' required>{$review['reviewText']}</textarea></label>
               <input type='submit' name='submit' value='Update' class='submitBtn'>
               <input type='hidden' name='action' value='Edit'>
               <input type='hidden' name='reviewId' value='{$review['reviewId']}'>
           </form>
       </div>";
       return $ed;
   }
       function buildDeleteView($review) {
       $date = $review['reviewDate'];
       $date = strtotime($date);
       $date = date("j F, Y", $date); 
       $dd = "<h1>Delete $review[invMake] $review[invModel] Review</h1>";
       $dd .= "<p>Reviewed on $date</p>";
       $dd .= "<p class='warning'>Deletes cannot be undone. Are you sure you want to delete this review?</p>";
       $dd .= "<div class='addVehicle'>
       <form method='post' action='/phpmotors/reviews/index.php'>
       <span> Review Text</span><p>$review[reviewText]</p>
       <input type='submit' name='submit' value='Delete' class='submitBtn'>
       <input type='hidden' name='action' value='Delete'> <input type='hidden' name='reviewId' value='$review [reviewId] '>
       </form>
       </div>";
       return $dd;
       }


  ?>
  




