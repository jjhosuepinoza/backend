<?php 
//Reviews Controller


// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the review model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = navBuild($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action){

    case 'addReview':
        // Get the input
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = $SESSION['clientData'] ['clientId'];

        // Check for missing data
        if(empty($reviewText) ){
            $message = '<p>Please provide your review.</p>';
            $_SESSION['message'] = $message;
            header("Location: /phpmotors/vehicles?action=vehicleFeatures&invId=$invId");
            exit;
        }

        // Add the review to the database.
        $insOutcome = insReview($reviewText, $invId, $clientId);

        // Check and report the result
        if($insOutcome=== 1){
            $message = "<p>Review has been added.</p>";
            $_SESSION['message'] = $message;
            header("Location: /phpmotors/vehicles?action=vehicleFeatures&invId=$invId");
            exit;
        } else {
            header("Location: /phpmotors/vehicles?action=vehicleFeatures&invId=$invId");
            exit;
        }
        break;

    case 'confirmEdit':
        // Get user input.
        $reviewId = filter_input(INPUT_GET, 'review', FILTER_VALIDATE_INT);

        // Get the review information
        $review = getSpecificReview($reviewId);
    if(!($review)){
        $message ='Sorry. no review could be found';
    }
    else{
        $$displayReview = buildEditView($review);
    }

        // Deliver the view.
        include '../view/review-update.php';
        break;

    case 'editReview':
        // Get user input.
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if( empty($reviewText)){
            $message = '<p>Please write your review.</p>';
            $_SESSION['message'] = $message;
            include '../view/review-update.php';
            exit;
        }

        // Update the review
        $updateResult = updateReview($reviewText, $reviewId);

        // Generate the correct message.
        if ($updateResult == 1){
            $message = 'Your review was edited successfully';
            $_SESSION['message'] = $message ;
            header('location: /phpmotors/accounts');
            exit;
        } else
         {
            $message = 'Your review has not been updated, Try again';
       
            $_SESSION['message'] = $message ;
        }

        header("Location: /phpmotors/vehicles?action=editReview&invId=$invId");
        exit;
        break;

    case 'delete':
        // Get user input.
        $reviewId = filter_input(INPUT_GET, 'review', FILTER_VALIDATE_INT);

        // Get the review information
        $deleteResukt= buildReviewDisplay($reviewId);

        // Check and report the delete
        if($deleteResult ===1) {}
        
        
        include '../view/confirm-delete.php';
        break;

    case 'deleteReview':
        // Get user input.
        $reviewId = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_NUMBER_INT);

        // Delete the review.
        $deleteReport = deleteReview($reviewId);

       // Check and report the result
if ($deleteResult === 1) {
    $message = "<p >The review was deleted successfully!</p>";
    $_SESSION['message'] = $message;
    header('location: /phpmotors/accounts/');
    exit;
    } else {
    $message = "<p >Sorry, but review deletion failed. Please try again.</p>";
    $_SESSION['message'] = $message;
    header('location: /phpmotors/accounts/');
    exit;
    }
    break;
    default:
    header("location: /phpmotors/accounts/");
    exit;
    break;
    }
    
    ?>

