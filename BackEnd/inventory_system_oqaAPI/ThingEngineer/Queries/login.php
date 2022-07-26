<?php
//prevents xsrf
require_once("cors.php");

//generate jwt
require_once("jwtgenerate.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");


//receive data
$data = file_get_contents('php://input');
$to_decode = json_decode($data);
$username = $to_decode->d1;
$password = $to_decode->d2;

//select query
$db->where ("uname", $username);
$db->where ("password", $password);
$user = $db->getOne ("tbl_user");

//display result
if($db->count > 0){
	$token = jwtgenerate($user['user_id']); //this is the jwt_token
	$data = Array ("user_id" => $user['user_id'], //set authentication for later use
		"token" => $token,
               "expiration" => expirationTimeStamp()//function called from the jwtgenerate php file
           );
	$user_auth_id = $db->insert ('tbl_user_auth', $data);


	http_response_code(200);
	echo json_encode(array(
		'login' 		=> true,
		'msg' 			=> "item found",
		'user_id' 		=> $user['user_id'],
		'uname' 		=> $user['uname'],
		'password' 		=> $user['password'],
		'token'		 	=> $token,
		'user_auth_id' 	=> $user_auth_id
	));

}else{
	echo json_encode(array('msg' => "\"Username\" or \"Password\" doesn't exist\nPlease check your input"));
}
?>