<?php 
/********************
 * Main controller
 *******************/ 

// Create or access a Session
session_start();

//This is the main controller
// Get the functions library
require_once 'library/functions.php';
//Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the array of classifications from DB using model
// Get the array of classifications
$classifications = getClassifications();

// var_dump($classifications);
// 	exit;

// Build a navigation bar using the $classifications array
$navList = navBuild($classifications);

// Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
  $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 }

//switch

$classifications = getClassifications();
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
$action = filter_input(INPUT_GET, 'action');
}
switch ($action){
 case 'template':
  include 'view/template.php';
     
 break;
    
 default:
 include 'view/home.php';
  }
?> 