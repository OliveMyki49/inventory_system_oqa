<?php
//forgot_password_update.php
//prevents xsrf
require("cors.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");

//for sms api
require_once 'telerivet-php-client-master/telerivet.php';

/*THIS IS FOR SMS DO NOT TOUCH IF YOU WANT THE SMS API TO WORK*/
$api_key = "PzCAV_ObmTLDWiPFdon9jOgIeHu517WPX3ym"; // see https://telerivet.com/dashboard/api
$project_id = "PJdc5e87ae774d0944";
$tr = new Telerivet_API($api_key);
$project = $tr->initProjectById($project_id);


//receive data
$data = file_get_contents('php://input');
$to_decode = json_decode($data);

$uname			= $to_decode->d1;

// Reset Password
$db->where('uname', $uname);
$users = $db->get('tbl_user');
if ($db->count > 0){

	// get contact number
	$db->where('uname', $uname);
	$user 				= $db->getOne('tbl_user');
	$db->where('official_id', $user['official_id']);
	$official 			= $db->getOne('tbl_barangayofficials');
	$db->where('resident_id', $official['resident_id']);
	$residentContactNo 	= $db->getOne('tbl_residents');
	$contact_no 		= $residentContactNo['contact_no'];

	$randomDigit = rand(1000,9999);
	$newpassword = "password".$uname."".$randomDigit;

	$resetPasswordata = Array (
		"password" => $newpassword,
	);
	$db->where ('uname', $uname);
	if ($db->update ('tbl_user', $resetPasswordata)){
		//send confirma new password set
		$sent_msg = $project->sendMessage(array(
			'content' => "Your new password is \"".$newpassword."\"", 
			'to_number' => $contact_no
		));

		echo json_encode(array('msg' => "New Password has been set. Check your SMS notification in your device to check your new password or if you didn't get an SMS notification, contact your system admin."));
	}else{
		echo json_encode(array('msg' => 'password update failed: ' . $db->getLastError()));
	}
}else{
	echo json_encode(array('msg' => "Username does not exist"));
}
?>