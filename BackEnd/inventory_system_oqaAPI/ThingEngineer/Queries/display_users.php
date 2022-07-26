<?php
//prevents xsrf
require("cors.php");

//thingengineer query library
require_once("../MysqliDb.php");

//connection
require_once("conn.php");

//get all data
$users = $db->get ("tbl_user");

$dataObj = [];
if ($db->count > 0){
	foreach ($users as $user) {
		if($user["remove"] == 0){
			$db->where ("official_id", $user["official_id"]);
			$officials = $db->get ("tbl_barangayofficials");
			if ($db->count > 0){
				foreach ($officials as $official) {
					$db->where("resident_id", $official["resident_id"]);
					$residentInfos = $db->get("tbl_residents");
					if ($db->count > 0){
						foreach ($residentInfos as $residentInfo) {
							$suffix = "";
							if( $residentInfo["suffix"] != "none"){
								$suffix = $residentInfo["suffix"];
							}

							array_push($dataObj, (object)[
								'user_id' => $user["user_id"],
								'official_id' => $user["official_id"],
								'uname' => $user["uname"],

								'fullname' => $residentInfo["fname"] ." ". $residentInfo["mname"] ." ". $residentInfo["sname"] . " ". $suffix,
								'position' => $official["position"],

								'status' => $user["status"]
							]);
						}
					}
				}
			}
		}
	}
}


echo json_encode(array('arraydata' => $dataObj));
?>