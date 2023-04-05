<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';

  
// get database connection
$database = new Database();
$db = $database->getConnection();
  

//get id to be edited
$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

$query = "UPDATE erotimatologia SET active=2 WHERE id=$id;";
$stmt = $db->prepare($query);




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



?>