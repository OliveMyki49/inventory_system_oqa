<?php
//prevents xsrf
require("cors.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");

//get payload
$column = $_GET['column'];
$value = $_GET['value'];

//seach for all data with specific keyword given
$db->where ($column, '%'.$value.'%', 'like');
$cols = Array ("user_id", "official_id", "uname", "status");
$users = $db->get ("tbl_user", null, $cols);

$dataObj = [];
if ($db->count > 0){
    foreach ($users as $user) { 
        array_push($dataObj, (object)[
        	'user_id' => $user["user_id"],
        	'official_id' => $user["official_id"],
        	'uname' => $user["uname"],
        	'status' => $user["status"]
        ]);
    }
}

echo json_encode(array('arraydata' => $dataObj));

?>