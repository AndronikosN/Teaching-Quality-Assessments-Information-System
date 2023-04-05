<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;



$query2 = "DELETE FROM questions WHERE id=$id;";
$stmt2 = $db->prepare($query2);

$query3 = "DELETE FROM answers WHERE quest_id=$id;";
$stmt3 = $db->prepare($query3);

if($stmt3->execute()) {
     // set response code - 200 ok
     http_response_code(200);
  
     // tell the user
     echo json_encode(array("message" => "All the answers of the questions were deleted."));
}
else {
     // set response code - 503 service unavailable
     http_response_code(503);
  
     // tell the user
     echo json_encode(array("message" => "Unable to delete listing."));
}

if($stmt2->execute()) {
     // set response code - 200 ok
     http_response_code(200);
  
     // tell the user
     echo json_encode(array("message" => "All the questions were deleted."));
} 
else {
     // set response code - 503 service unavailable
     http_response_code(503);
  
     // tell the user
     echo json_encode(array("message" => "Unable to delete listing."));
}



?>