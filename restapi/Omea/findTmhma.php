<?php

//required headers
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: *"); //file can be read by anyone
header("Content-Type: application/json; charset=UTF-8"); //Content type is utf8
header("Access-Control-Allow-Methods: POST,GET,OPTIONS,DELETE,PUT"); //indicates which HTTP methods are allowed
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");


//include database and object files
include_once '../config/database.php';


// instatiate database 
$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

$query = "SELECT tmhmata.id, tmhmata.name FROM tmhmata, kathhghtes WHERE kathhghtes.id=$id AND kathhghtes.tmhma_id=tmhmata.id;";
$stmt = $db->prepare($query);

$stmt->execute();
$num = $stmt->rowCount();

$tmhmata_array = array();
//$tmhmata_array["records"] = array();

 if($num>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $tmhmata_item = array(
            "value" => $id,
            "label" => $name
        );

        array_push($tmhmata_array, $tmhmata_item);

    }

    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($tmhmata_array);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(404);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }

?>