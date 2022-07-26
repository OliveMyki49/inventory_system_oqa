<?php
//prevents xsrf
require_once("cors.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");


//receive data
$user_auth_id = $_GET['d1']; //get from url

//select query
$db->where ("user_auth_id", $user_auth_id);
$user = $db->getOne ("tbl_user_auth");


//display result
if($db->count > 0){
	echo json_encode(array(
		'auth' => true,
		'user_id' => $user['user_id'],
		'token' => $user['token'],
		'expiration' => $user['expiration'],
	));
}else{
	echo json_encode(array('auth' => false));
}
?>