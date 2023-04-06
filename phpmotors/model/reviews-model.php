<?php

//Review Model

// The function inserts a review in the review table.
function getReviewText($reviewId)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT reviewText FROM reviews WHERE reviewId = :reviewId';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
 
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
 
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// The function gets reviews for an inventory item.
function insReview($reviewText, $invId, $clientId){
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews, (:reviewText, :invId, :clienteId)
    VALUES (:reviewText, :inIvd :clientId)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//Get reviews for a specific inventory item
function getReviewsByItem($invId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews INNER JOIN clients ON clients.clientId = reviews.clientId WHERE invId :invId ORDER BY reviewId DESC'; 
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO:: PARAM_INT);
    $stmt->execute(); 
    $reviews = $stmt->fetchAll(PDO:: FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;
    }

//Get reviews written by a specific client
    function getReviewsByClient ($clientId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews INNER JOIN inventory ON reviews.invId = inventory.invId WHERE clientId = :clientId ORDER BY reviewId DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO:: PARAM_INT);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO:: FETCH_ASSOC);
    $stmt->closeCursor();
    return $reviews;

    }
    //Get specific review
    function getSpecificReview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews INNER JOIN inventory ON reviews.invId = inventory.invId WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(': reviewId', $reviewId, PDO:: PARAM_INT); 
    $stmt->execute();
    $review = $stmt->fetch (PDO:: FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
    }
   
    
    // Update specific review
function updateReview ($reviewId, $reviewText) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId'; 
    
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // The next lines replace the placeholders in the SQL
   
    $stmt->bindValue(':reviewId', $reviewId, PDO:: PARAM_INT);
    $stmt->bindValue(':reviewText', $reviewText, PDO:: PARAM_STR);
    // Update the data
    $stmt->execute();
    // Ask how many rows changed as a result of our update 
    $rowsChanged = $stmt->rowCount();
    
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
    }

    // Delete specific review
    function deleteReview($reviewId) {
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'DELETE FROM reviews WHERE reviewId = reviewId';
    // Create the prepared statement using the phpmotors connection 
    $stmt = $db->prepare($sql);
    // The next lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is 
    $stmt->bindValue(':reviewId', $reviewId, PDO:: PARAM_INT);
    // Update the data
    $stmt->execute();
    // Ask how many rows changed as a result of our update
    $rowsChanged = $stmt->rowCount(); // Close the database interaction
    
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
    }
    

?>