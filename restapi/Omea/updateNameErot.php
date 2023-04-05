<?php
//required headers
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: *"); //file can be read by anyone
header("Content-Type: application/json; charset=UTF-8"); //Content type is utf8
header("Access-Control-Allow-Methods: POST,GET,OPTIONS,DELETE,PUT"); //indicates which HTTP methods are allowed
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';

  
// get database connection
$database = new Database();
$db = $database->getConnection();
  

//get id to be edited
$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$title = $data->title;

$query = "UPDATE erotimatologia SET title='$title' WHERE id=$id;";
$stmt = $db->prepare($query);


if(!empty($title)) {
//update the product
    if($stmt->execute()) {
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "Listing was updated."));
    }
    // if unable to update the product, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update listing."));
    }
}



?>