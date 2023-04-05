<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object file
include_once '../config/database.php';

//initialize database
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));


$query = "SELECT * FROM kathhghtes";
$stmt = $db->prepare($query);

$stmt -> execute();
$num =  $stmt->rowCount();

$kathhghtes_array = array();


if($num>0) {

    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $kathhghtes_item = array(
            "value" => $id,
            "username" => $username,
            "label" => $name ." " .$lastname,  //the dots connect/join/append the stings
            "tmhma_id" => $tmhma_id,
            "utype" => $utype
        );

        array_push($kathhghtes_array,$kathhghtes_item);
    }

    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($kathhghtes_array);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(404);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }

?>