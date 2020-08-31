<?php
// include database connection
$root = $_SERVER['DOCUMENT_ROOT'];
include"dbcon.php";
 
try {
     
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
 
    // delete query 
    $query = "DELETE FROM Faculty WHERE f_id = ?";
    $stmt = $dbcon->prepare($query);
    $stmt->bindParam(1, $id);
     
    if($stmt->execute()){
        // redirect to read records page and 
        // tell the user record was deleted
        header('Location: faculty.php?action=deleted');
    }else{
        die('Unable to delete record.');
    }
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>