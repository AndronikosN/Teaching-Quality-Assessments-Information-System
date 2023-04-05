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



$query = "SELECT * FROM questions WHERE erot_id=$erot_id;";
$stmt = $db->prepare($query);

$stmt->execute();
$count = $stmt->rowCount();

$questions_array = array();
//$questions_array = array();

if($count>0) {
    //retrieve our table contents with fetch
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);  //makes $row['name'] to just $name only

        $query2 = "SELECT * FROM answers WHERE quest_id=$id;";
        $stmt2 = $db->prepare($query2);
        
        $stmt2->execute();
        $num = $stmt2->rowCount();

        
        $answers_array = array();
        if($num>0) {
        //retrieve our table contents with fetch
        while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            extract($row);  //makes $row['name'] to just $name only

            $option = array(
                "value" => $ans,
                "label" => $ans
            );
                
            array_push($answers_array, $option);

            
            }
            $questions_item = array(
                "id" => $id,
                "erot_id" => $erot_id,
                "question" => $question,
                "type" =>$type,
                "ans" => $answers_array,
                "exist" => 0
            );
    
        array_push($questions_array, $questions_item);
        }
    }
}

//set responce code - 200 OK
http_response_code(200);

//show data in json format
echo json_encode($questions_array);



?>