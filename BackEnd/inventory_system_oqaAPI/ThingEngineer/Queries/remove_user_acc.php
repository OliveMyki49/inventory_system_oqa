<?php
//remove_user_acc.php
//prevents xsrf
require("cors.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");


//receive data
$user_id = $_GET['id'];
$remove_reason = $_GET['remove_reason'];

//update query
$data = Array (
	'remove'	=> true,
	'remove_reason' => $remove_reason,
);
$db->where ('user_id', $user_id); //be mindful of using id 
if ($db->update ('tbl_user', $data)){
    echo json_encode(array('msg' => $db->count . ' records were removed'));
}else{
    echo json_encode(array('msg' => 'update failed: ' . $db->getLastError()));
}
?>