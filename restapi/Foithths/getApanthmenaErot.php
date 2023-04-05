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

$erot_id = $data->id;
$id_class = $data->id_class;
$am_id = $data->am_id;

$query = "SELECT * FROM apanthseis WHERE am_id=$am_id AND erot_id=$erot_id AND mathhma_id=$id_class;";
$stmt = $db->prepare($query);

$stmt->execute();
$num = $stmt->rowCount();

$apanthseis_array = array();
//$apanthseis_array["records"] = array();
/*
 if($num>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $apanthseis_item = array(
            "id" => $id,
            "erot_id" => $erot_id,
            "quest_id" => $quest_id,
            "ans" =>$ans,
            "mathhma_id"=>$mathhma_id,
            "am_id"=>$am_id,
            "year"=>$year
        );

        array_push($apanthseis_array["records"], $apanthseis_item);

    }


    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($apanthseis_array);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(200);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }
 */

 if($num>0) {
    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode(true);
 } else {
     //set responce doce - 404 Not Found
     http_response_code(200);

     //tell the user no records found
     echo json_encode(false);
 }

?>