<?php

/*************************
 *Vehicles controller
 *************************/

// Create or access a Session
session_start();

// Get the functions library
require_once '../library/functions.php';
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
//Get the uploads model
require_once '../model/uploads-model.php';
//Get the reviews model
require_once '../model/reviews-model.php';


// Get the array of classifications
$classifications = getClassifications();
// var_dump($classifications);
// exit;
// Build a navigation bar using the $classifications array
$navList = navBuild($classifications);
// echo $navList;
// exit;
// $classificationList = "<option value=''>Choose car classification</option>"; 
// foreach ($classifications as $classification) {
//     $classificationList .= "<option value=".urlencode($classification['classificationId']).">{$classification ['classificationName']}</option>";
// };


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
switch ($action) {
    case 'registerVehicle':
        // Filter and store the data
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if (($classificationId === "") || empty($invMake) || empty($invModel)
            || empty($invDescription) || empty($invImage) || empty($invThumbnail)
            || empty($invPrice) || empty($invStock) || empty($invColor)
        ) {
            $errorMessage = 'Please provide information for all empty form fields.';
            include '../view/add-vehicle.php';
            exit;
        };

        // Send the data to the model
        $insOutcome = insVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor);

        // Check and report the result
        if ($insOutcome === 1) {
            $message = "The $invMake $invModel was added successfully!";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "Sorry, but adding the vehicle failed. Please try again.";
            include '../view/add-vehicle.php';
            exit;
        }
        break;

    case 'registerClassification':
        // Filter and store the data
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        // $checkClassification = checkClassification($checkClassification);

        // Check for missing data
        if (empty($classificationName)) {
            $errorMessage = 'Please provide information for empty form field.';
            include '../view/add-classification.php';
            exit;
        };

        // Send the data to the model
        $insOutcome = insClassification($classificationName);

        // Check and report the result 
        if ($insOutcome == 1) {
            header("Location: index.php");
            include '../view/vehicle-man.php';
        } else {
            $message = "Sorry, but adding $classificationName failed. Please try again.";
            include '../view/add-classification.php';
            exit;
        }
        break;

    case 'classification-page':
        include '../view/add-classification.php';
        break;




        /* * ********************************** 
* Get vehicles by classificationId 
* Used for starting Update & Delete process 
* ********************************** */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

 
    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;


        case 'updateVehicle':
            $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
            $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
            $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
            
            if (empty($classificationId) || empty($invMake) || empty($invModel) 
            || empty($invDescription) || empty($invImage) || empty($invThumbnail)
            || empty($invPrice) || empty($invStock) || empty($invColor)) {
          $message = '<p>Please complete all information for the item! Double check the classification of the item.</p>';
             include '../view/vehicle-update.php';
         exit;
        }
        
        $updateResult = updateVehicle(
            $invMake, 
            $invModel, 
            $invDescription, 
            $invImage, $invThumbnail, 
            $invPrice, 
            $invStock, 
            $invColor, 
            $classificationId, 
            $invId);
        if ($updateResult) {
         $message = "<p class='notice'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error. the $invMake $invModel was not updated.</p>";
             include '../view/vehicle-update.php';
             exit;
            }
        break;

        case 'del':
            $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
            $invInfo = getInvItemInfo($invId);
            if (count($invInfo) < 1) {
                    $message = 'Sorry, no vehicle information could be found.';
                }
                include '../view/vehicle-delete.php';
                exit;
                break;

                case 'deleteVehicle':
                    $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    $deleteResult = deleteVehicle($invId);
                    if ($deleteResult) {
                        $message = "<p class='notice'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
                        $_SESSION['message'] = $message;
                        header('location: /phpmotors/vehicles/');
                        exit;
                    } else {
                        $message = "<p class='notice'>Error: $invMake $invModel was not
                    deleted.</p>";
                        $_SESSION['message'] = $message;
                        header('location: /phpmotors/vehicles/');
                        exit;
                    }
                    break;

    case 'vehicle-page':
        include '../view/add-vehicle.php';
        break;


case 'classification':
 $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 $vehicles = getVehiclesByClassification($classificationName);
 if(!count($vehicles)){
  $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
 } else {
  $vehicleDisplay = buildVehiclesDisplay($vehicles);
 }
 include '../view/classification.php';
 break;


 
 case 'vehicleFeatures':

    $vehicleId = filter_input(INPUT_GET, 'vehicleId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $vehicleSelected = getVehicleDetailInfo($vehicleId);
    $thumbnails = getThumbnailImages($vehicleId);
    if(!count($vehicleSelected)){
        $message = "<p>Sorry, the vehicle selected could not be found.</p>";
    } else {
        $vehicleSelectedDisplay = buildVehicleSelectedDisplay($vehicleSelected,$thumbnails);
    }

    include '../view/vehicle-detail.php';
    break;
    


       default:
        $classificationList = buildClassificationList($classifications);
        include "../view/vehicle-man.php";
        exit;
        break;
}

?>