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

$user_id		= $to_decode->d1;
$official_id	= $to_decode->d2;
$uname			= $to_decode->d3;
$status			= $to_decode->d4;
$resetPassword	= $to_decode->d5;

if($uname != "UserBPIMS"){
	$confirmResetPass = "";
	if($resetPassword == true){
		$resetPasswordata = Array (
			"password" => "password".$uname."".$official_id,
		);
		$db->where ('user_id', $user_id);
		if ($db->update ('tbl_user', $resetPasswordata)){
			$confirmResetPass = " -> NEW PASSWORD: password".$uname."".$official_id;
		}else{
			$$confirmResetPass = 'password update failed: ' . $db->getLastError();
		}
	}

	$data = Array (
		"official_id" => $official_id,
		"uname" => $uname,
		"status" => $status,
	);
	$db->where ('user_id', $user_id);
	if ($db->update ('tbl_user', $data)){
		echo json_encode(array('msg' => $db->count . ' records were updated'. $confirmResetPass));
	}else{
	    //echo json_encode(array('msg' => 'update failed: ' . $db->getLastError()));
		echo json_encode(array('msg' => 'Update Failed: Username already exist'));
	};
}else{
	echo json_encode(array('msg' => 'Update Failed: Username already exist'));
}
?>