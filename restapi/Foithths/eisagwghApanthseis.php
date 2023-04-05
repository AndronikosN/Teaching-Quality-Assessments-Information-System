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

$erot_id = $data->erot_id;
$quest_id = $data->quest_id;
$ans = $data->ans;
$mathhma_id = $data->mathhma_id;
$am_id = $data->am_id;
$year = $data->year;

for($i=0; $i<count($ans); $i++) {
    //query to insert record
    $query = "INSERT INTO apanthseis (erot_id,quest_id,ans,mathhma_id,am_id,year) VALUES (:erot_id,:quest_id,:ans,:mathhma_id,:am_id,:year)";
        
    //prepare query
   $stmt = $db->prepare($query);

   //sanitize
   $erot_id=htmlspecialchars(strip_tags($erot_id));
   $quest_id[$i]=htmlspecialchars(strip_tags($quest_id[$i]));
   $ans[$i]=htmlspecialchars(strip_tags($ans[$i]));
   $mathhma_id=htmlspecialchars(strip_tags($mathhma_id));
   $am_id=htmlspecialchars(strip_tags($am_id));
   $year=htmlspecialchars(strip_tags($year));

   //bind values
   $stmt->bindParam(':erot_id', $erot_id);
   $stmt->bindParam(':quest_id', $quest_id[$i]);
   $stmt->bindParam(':ans', $ans[$i]);
   $stmt->bindParam(':mathhma_id', $mathhma_id);
   $stmt->bindParam(':am_id', $am_id);
   $stmt->bindParam(':year', $year);

   $stmt->execute();
}


?>