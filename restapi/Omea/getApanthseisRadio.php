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

$quest_id = $data -> quest_id;
$class_id = $data -> class_id;

//gia na broume poies einai oles oi pithanes apanthseis
$query = "SELECT answers.ans FROM answers WHERE quest_id=$quest_id";
$stmt = $db->prepare($query);

$stmt->execute();
$num = $stmt->rowCount();

$apanthseis_radio = array();  //ton xreiazomaste gia if elegxo meta
$apanthseis["labels"] = array(); //ton xreiazomaste me tampela gia na json encode


if($num>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        array_push($apanthseis_radio, $ans);
        array_push($apanthseis["labels"], $ans);
    }

}

//gia na broume oles tis apanthseis twn foithtwn
$query2="SELECT * FROM apanthseis WHERE quest_id=$quest_id AND mathhma_id=$class_id";
$stmt2 = $db->prepare($query2);

$stmt2->execute();
$num2 = $stmt2->rowCount();

$apanthseis_radio_array = array();

if($num2>0) {
    //retrieve our table contents with fetch
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only


        array_push($apanthseis_radio_array,$ans);
    }
    $apanthseisPososta["data"] = array(); //poses fores dothhke kathe apanthsh
    //elegxos, diadikh ap
    for($i=0; $i<$num; $i++) {
        $count = 0;
       for($y=0; $y<$num2; $y++){
            if($apanthseis_radio[$i] == $apanthseis_radio_array[$y]) {
                $count++;
            }
       }

       array_push($apanthseisPososta["data"],$count);
   
    }

    

    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($apanthseis+$apanthseisPososta);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(404);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }


?>