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
$question = $data->question;
$type = $data->type;
$ans = $data->ans;


 //query to insert record
 $query = "INSERT INTO  questions (erot_id,question,type) VALUES (:erot_id, :question, :type)";

 //prepare query
 $stmt = $db->prepare($query);

 //sanitize  
 $erot_id=htmlspecialchars(strip_tags($erot_id));    
 $question=htmlspecialchars(strip_tags($question));
 $type=htmlspecialchars(strip_tags($type));

 //bind values

 $stmt->bindParam(':erot_id', $erot_id);
 $stmt->bindParam(':question', $question);
 $stmt->bindParam(':type', $type);

 $stmt->execute();

$quest_id = $db->lastInsertId(); //epistrefei to teleutaio id pou egine insert sth bash. oti kai na einai

if($type == 1) {
    for($i=0; $i<count($ans); $i++) {
        //query to insert record
        $query2 = "INSERT INTO answers (erot_id,quest_id,ans) VALUES (:erot_id,:quest_id,:ans)";
        
         //prepare query
        $stmt2 = $db->prepare($query2);

        //sanitize
        $erot_id=htmlspecialchars(strip_tags($erot_id));
        $quest_id=htmlspecialchars(strip_tags($quest_id));
        $ans[$i]=htmlspecialchars(strip_tags($ans[$i]));

        //bind values
        $stmt2->bindParam(':erot_id', $erot_id);
        $stmt2->bindParam(':quest_id', $quest_id);
        $stmt2->bindParam(':ans', $ans[$i]);

        $stmt2->execute();

    }

} else {
    $ans2='textarea';

    $query3 = "INSERT INTO answers (erot_id,quest_id,ans) VALUES (:erot_id,:quest_id,:ans)";
    
     //prepare query
    $stmt3 = $db->prepare($query3);

    //sanitize
    $erot_id=htmlspecialchars(strip_tags($erot_id));
    $quest_id=htmlspecialchars(strip_tags($quest_id));
    $ans2=htmlspecialchars(strip_tags($ans2));

    //bind values
    $stmt3->bindParam(':erot_id', $erot_id);
    $stmt3->bindParam(':quest_id', $quest_id);
    $stmt3->bindParam(':ans', $ans2);

    $stmt3->execute();
}

?>