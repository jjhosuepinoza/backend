<?php 
/********************
 * Account Controler
 ********************/ 

// Create or access a Session
session_start();


// Get the functions library
require_once '../library/functions.php';
//Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
//Get the accounts model
require_once '../model/accounts-model.php';
//Get the reviews modeñ
require_once '../model/reviews-model.php';

// Get the array of classifications from DB using model
// Get the array of classifications
$classifications = getClassifications();
//

//  var_dump($classifications);
//  	exit;

// Build a navigation bar using the $classifications array

$navList = navBuild($classifications);

// echo $navList;
// exit;

// Control switch

$action = filter_input(INPUT_POST, 'action');

if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}



switch ($action){
 // Code to deliver the views will be here
 
case "register":

  // Filter and store the data
    $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
    $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
    $clientEmail = checkEmail($clientEmail);
    $checkPassword = checkPassword($clientPassword);

    $existingEmail = checkExistingEmail($clientEmail);
    
    // Check for existing email address in the table
    if($existingEmail){
     $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
     include '../view/login.php';
     exit;
    }
   
  // Check for missing data
  if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
    $message = '<p> Please provide information for all empty form fields.</p>';
    include '../view/registration.php';
    exit;
  }

// Hash the checked password
$hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

// Send the data to the model
$regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
  
  // Check and report the result
  if($regOutcome === 1){
    setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
    $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
    header('Location: /phpmotors/accounts/?action=login');
    exit;
  } else {
    $message = "<p >Sorry $clientFirstname, but the registration failed. Please try again.</p>";
    include '../view/registration.php';
    exit;
  }
  break;
  
  case 'register-page':
  include '../view/registration.php';
  break;

  case 'login':
    include '../view/login.php';
    break;

  case 'Login':
    $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
    $clientEmail = checkEmail($clientEmail);
    $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $passwordCheck = checkPassword($clientPassword);
    
    // Run basic checks, return if errors
    if (empty($clientEmail) || empty($passwordCheck)) {
     $message = '<p class="notice">Please provide a valid email address and password.</p>';
     include '../view/login.php';
     exit;
    }
      
    // A valid password exists, proceed with the login process
    // Query the client data based on the email address
    $clientData = getClient($clientEmail);
    // Compare the password just submitted against
    // the hashed password for the matching client
    $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
    // If the hashes don't match create an error
    // and return to the login view
    if(!$hashCheck) {
      $message = '<p class="notice">Please check your password and try again.</p>';
      include '../view/login.php';
      exit;
    }

    // A valid user exists, log them in
    $_SESSION['loggedin'] = TRUE;
    // Remove the password from the array
    // the array_pop function removes the last
    // element from an array
    array_pop($clientData);
    // Store the array into the session
    $_SESSION['clientData'] = $clientData;
    // Send them to the admin view
    $message = 'You are loged in';

    $reviewList = getReviewsByClient($_SESSION['clientData']['clientId']);
    $reviewHTML = '<ul>';
    foreach($reviewList as $review){
        $reviewHTML .= buildReviewDisplay($review['reviewDate'], $review['reviewId']);
    }
    $reviewHTML .= '</ul>';

    include '../view/admin.php';
    exit;    
    break;



    case 'Logout':
     //unset the session
     session_unset();
      //destroy the session
      session_destroy();
      header('Location:/phpmotors');
      exit;
      break;
 

      ///Update//

     case 'manageAccount':
      include '../view/client-update.php';
        break;

      case 'updateInformation':
          // Filter and store the data
          $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
          $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
  
          // Validate email on server side
          $clientEmail = checkEmail($clientEmail);
  
          if ($clientEmail !== $_SESSION['clientData']['clientEmail']) {
              // Check if email exists in clients database table
              $accountExists = checkExistingEmail($clientEmail);
              if ( $accountExists ) {
                  $message = '<p class="error-message">There is already another account using the email ' . $clientEmail . '.</p>';
                  include '../view/client-update.php';
                  exit;
              }
          }
  
          // Check for missing data
          if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)){
              $message = "<p class='notice'>All form fields are required.</p>";
              include '../view/client-update.php';
              exit; 
          }
  
          // Insert the data to the database.
          $updateResult = updateClient( $clientFirstname, $clientLastname, $clientEmail, $clientId );
  
          // Check and report the result.
          if ($updateResult === 1) {
              setcookie("firstname", $clientFirstname, strtotime("+ 1 year"), "/");
              $_SESSION['message'] = "<p class='notice'>Account information updated successfully.</p>";
              // Update clientData in the session.
              $clientData = getClientById($clientId);
              array_pop($clientData);
              $_SESSION['clientData'] = $clientData;
              header('Location: /phpmotors/accounts/');
              exit;
          } else {
              $message = "<p class='notice'>Account update failed. Please try again.</p>";
              include '../view/client-update.php';
              exit;
          }
          break;

    case 'newPassword':
         // Filter and store the data
         $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);        
         
         // Validate password on server side
         $checkPassword = checkPassword($clientPassword);
 
         // Check for missing data
         if(empty($checkPassword)){
             $passMessage = "<p class='notice'>Please enter a valid password.</p>";
             include '../view/client-update.php';
             exit; 
         }
 
         // Hash the checked password
         $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
 
         // Send the data to the model
         $updateOutcome = updatePassword($clientId, $hashedPassword);
 
    
         // Check and report the result
         if($updateOutcome === 1){
          $_SESSION['message']  = "The password has been updated succesfully.";
          header('Location: /phpmotors/accounts/');
             exit;
         } else {
             $passMessage = "<p>Sorry, but the updating failed. Please try again.</p>";
             include '../view/client-update.php';
             exit;
         }
         break;



  default:

  $reviewList = getReviewsByClient($_SESSION['clientData']['clientId']);
  $reviewHTML = '<ul>';
  foreach($reviewList as $review){
      $reviewHTML .= buildReviewDisplay($review['reviewDate'], $review['reviewId']);
  }
  $reviewHTML .= '</ul>';

  include '../view/admin.php';

   }
?> 