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

$am = $data->am;
$year = $data->year;


$query = "SELECT dhlwseis.id,id_am,id_class,year,title,eclass_code,prof_id FROM dhlwseis,mathhmata
WHERE id_am=$am AND year='$year' AND id_class=mathhmata.id;";
$stmt = $db->prepare($query);

$stmt->execute();
$num = $stmt->rowCount();

$dhlwseis_array = array();
$dhlwseis_array["records"] = array();

 if($num>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $dhlwseis_item = array(
            "id" => $id,
            "id_am" => $id_am,
            "id_class" => $id_class,
            "year" => $year,
            "title" => $title,
            "eclass_code" => $eclass_code,
            "prof_id" => $prof_id
        );

        array_push($dhlwseis_array["records"], $dhlwseis_item);

    }

    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($dhlwseis_array);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(404);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }

?>