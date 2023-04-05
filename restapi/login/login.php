<?php
include_once './config/database.php';
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,  WWW-Authenticate");


$username = '';
$password = '';


$database = new Database();
$db = $database->getConnection();




$data = json_decode(file_get_contents("php://input"));


$username = $data->username;
$password = $data->password;    



$query="SELECT * FROM foithtes ";
$stmt = $db->prepare($query);
$stmt->execute();

$query2="SELECT * FROM kathhghtes";
$stmt2 = $db->prepare($query2);
$stmt2->execute();

while($row = $stmt->fetch()) {
    if($username==$row['username'] && $password==$row['password']){
    $tmhma_id = $row['tmhma_id'];
    $name = $row['name'];
    $lastname = $row['lastname'];
    $utype = $row['utype'];
    $am = $row['am'];
    
    
        $secret_key = "123456789";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim ; //not before in seconds
        $expire_claim = $issuedat_claim + (60*15); // expire time in seconds
        $token = array(
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "utype" => $utype,
            "data" => array(
                "tmhma_id" => $tmhma_id,
                "name" => $name,
                "lastname" => $lastname,
                "utype" => $utype,
                "am" => $am
        ));

        http_response_code(200);
        

        
        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "res" => 1,
                "utype" => $utype,
                "am" => $am,
                "tmhma_id" => $tmhma_id,
                "message" => "Successful login.",
                "jwt" => $jwt,
                "expireAt" => $expire_claim
            ));
    } else{
        while($row = $stmt2->fetch()) {
            if($username==$row['username'] && $password==$row['password']){
            $tmhma_id = $row['tmhma_id'];
            $name = $row['name'];
            $lastname = $row['lastname'];
            $utype = $row['utype'];
            $id=$row['id'];
            
            
                $secret_key = "123456789";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim ; //not before in seconds
                $expire_claim = $issuedat_claim + (60*15); // expire time in seconds
                $token = array(
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "utype" => $utype,
                    "data" => array(
                        "tmhma_id" => $tmhma_id,
                        "name" => $name,
                        "lastname" => $lastname,
                        "utype" => $utype,
                ));
        
                http_response_code(200);
                
        
                
                $jwt = JWT::encode($token, $secret_key);
                echo json_encode(
                    array(
                        "res" => 1,
                        "utype" => $utype,
                        "message" => "Successful login.",
                        "id" => $id,
                        "tmhma_id" => $tmhma_id,
                        "jwt" => $jwt,
                        "expireAt" => $expire_claim
                    ));
            }
    
        }
    }
}

?>