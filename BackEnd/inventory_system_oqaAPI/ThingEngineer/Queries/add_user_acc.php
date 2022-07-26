<?php
//prevents xsrf
require("cors.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");


//receive data
$data = file_get_contents('php://input');
$to_decode = json_decode($data);
$official_id = $to_decode->d1;
$uname		= "UserBPIMS";
$password = "UserBPIMS";

//check if user name is already existing
$db->where ("uname", $uname);
$users = $db->get ("tbl_user");
if ($db->count == 0){
	//add query
	$data = Array (
		"official_id" => $official_id,
	    "uname" => $uname,
		"password" => $password,
		"status" => 'active'
	);
	$id = $db->insert ('tbl_user', $data);

	if($id){
		//update query
		$renameuser = Array (
			"uname" => "UserBPIMS". $id,
			"password" => "password4509". $id,
		);
		$db->where("user_id", $id);
		if ($db->update ('tbl_user', $renameuser)){
			http_response_code(200);
			echo json_encode(array('msg' => "New User Added\nUser Id: ". $id ."\nUser Name: ". $uname ."". $id ."\nGenerated Password: password4509". $id));
		}else{
		    echo json_encode(array('msg' => 'update failed: ' . $db->getLastError()));
		}
	}
}else{
	echo json_encode(array('msg' => "User with name '". $uname ."' already exist"));
}


?>