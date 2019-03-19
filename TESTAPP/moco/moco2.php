<?php

$secret_key = "";

//parameters sent by moco server
$tid = $_POST['tid']; //txn id
$userid = $_POST['userid']; //moco userid
$status = $_POST['status']; //txn status S or F
$message = $_POST['message']; // status message
$name = $_POST['name'];//moco user's name
$email = $_POST['email']; //moco user's email
$hash = $_POST['hash']; //hmac hash

//generate hash on merchant side using values sent by moco
if($status == 'S')
{
	$myHash = hash_hmac("md5", $tid.$status.$message.$userid.$name.$email, $secret_key);
}else{
	$myHash = hash_hmac("md5", $tid.$status.$message.$userid, $secret_key);
}


//validate authenticity of the received data
if($myHash == $hash){
	//data sent from Moco Server
	//do your stuff
}else{
	//spoofed data
	//ignore
}

?>