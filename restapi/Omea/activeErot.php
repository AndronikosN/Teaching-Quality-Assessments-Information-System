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

$tmhma_id = $data->tmhma_id;

$today = date("y-m-d");


$query3 = "SELECT * FROM erotimatologia WHERE tmhma_id=$tmhma_id;";
$stmt3 = $db->prepare($query3);

$stmt3->execute();
$num2 = $stmt3->rowCount();

//$erotimatologia_array = array();
if($num2>0) {
    //retrieve our table contents with fetch
    while($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only
        
        if(strtotime($expire) < strtotime($today) && $active ==1){
            $query4 = "UPDATE erotimatologia SET active=2 WHERE id=$id;";
            $stmt4 = $db->prepare($query4);

            $stmt4->execute();
        }

    }
 }



$query = "SELECT * FROM erotimatologia WHERE tmhma_id=$tmhma_id AND active=1;";
$stmt = $db->prepare($query);

$stmt->execute();
$num = $stmt->rowCount();

$inactiveErot_array = array();
$inactiveErot_array["records"] = array();

 if($num>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $query2 = "SELECT * FROM questions WHERE erot_id=$id;";
        $stmt2 = $db->prepare($query2);

        $stmt2->execute();
        $count = $stmt2->rowCount();


        $inactiveErot_item = array(
            "id" => $id,
            "title" => $title,
            "tmhma_id" => $tmhma_id,
            "active" =>$active,
            "expire" =>$expire,
            "prof_id" => $prof_id,
            "NumOfQuest" => $count,
            "date" => $today
        );

        array_push($inactiveErot_array["records"], $inactiveErot_item);

    }

    //set responce code - 200 OK
    http_response_code(200);

    //show data in json format
    echo json_encode($inactiveErot_array);

 } else {
     //set responce doce - 404 Not Found
    http_response_code(200);

    //tell the user no records found
    echo json_encode(
        array("message" => "No Products found.")
    );
 }

?>