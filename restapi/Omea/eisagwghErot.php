<?php
//required headers
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: *"); //file can be read by anyone
header("Content-Type: application/json; charset=UTF-8"); //Content type is utf8
header("Access-Control-Allow-Methods: POST,GET,OPTIONS,DELETE,PUT"); //indicates which HTTP methods are allowed
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");



//get database connection
include_once "../config/database.php";


// instatiate database 
$database = new Database();
$db = $database->getConnection();

//get posted data
$data = json_decode(file_get_contents("php://input"));


$title = $data->title;
$tmhma_id = $data->tmhma_id;
$expire = $data->expire;
$prof_id = $data->prof_id;


if (
    true
) {
    //query to insert record
    $query = "INSERT INTO  erotimatologia (title,tmhma_id,active,expire,prof_id) VALUES (:title, :tmhma_id, 0,:expire,:prof_id)";

    //prepare query
    $stmt = $db->prepare($query);
 
    //sanitize
    //$this->quiz_id=htmlspecialchars(strip_tags($this->quiz_id));  
    $title=htmlspecialchars(strip_tags($title));    
    $tmhma_id=htmlspecialchars(strip_tags($tmhma_id));
    $expire=htmlspecialchars(strip_tags($expire));
    $prof_id=htmlspecialchars(strip_tags($prof_id));

    //bind values
    //$stmt->bindParam(":quiz_id", $this->quiz_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':tmhma_id', $tmhma_id);
    $stmt->bindParam(':expire', $expire);
    $stmt->bindParam(':prof_id', $prof_id);
    

    //execute query
    if($stmt->execute()){
        //set responce - 201 Created
        http_response_code(201);
        //tell the user
        echo json_encode(array("message" => "Listing was created"));
    } 
    //if unable to create, tell the user
    else {

        //set responce code - 503 service unavailable
        http_response_code(503);

        //tell the user
        echo json_encode(array("messsage" => "Unable to create listing."));
    }

}else {

    //set responce code - 400 bad request
    http_response_code(400);

    //tell the user
    echo json_encode(array("message" => "Unable to create listing. Data is incomplete"));
}

?>