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


$query = "SELECT mathhmata.id,mathhmata.title,mathhmata.eclass_code,mathhmata.semester,mathhmata.prof_id,mathhmata.tmhma_id,tmhmata.name
          FROM mathhmata,tmhmata 
          WHERE prof_id=$id AND tmhmata.id=mathhmata.tmhma_id;";
$stmt = $db->prepare($query);

$stmt->execute();
$num = $stmt->rowCount();

$mathhmata_array = array();
$mathhmata_array["records"] = array();

 if($num>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $mathhmata_item = array(
            "id" => $id,
            "title" => $title,
            "eclass_code" => $eclass_code,
            "semester" => $semester,
            "tmhma_id" => $tmhma_id,
            "name" =>$name
        );

        array_push($mathhmata_array["records"], $mathhmata_item);

    }

    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($mathhmata_array);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(404);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }

?>