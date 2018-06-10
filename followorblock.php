<?php
session_start();
include_once("method.php");
$connection = getConnectionToDb();

$followsql = "insert ";
$foo = $_SESSION["uid"]; 		//logged in user
$val = $_POST['fid'];			//user id who is being searched/followed/blocked
$valname = $_POST["fname"];		//user name who is being searched/followed
if(isset($_POST['act'])){

}
$act = $_POST['act'];
//echo "$val $valname $act";

$sql1 = "Select distinct MAIN_UID from followers where f_uid='".$foo."' And BLOCK_FLAG = TRUE";
$arr = mysqli_query($connection, $sql1);
$users = array();
while($data = mysqli_fetch_object($arr)){
	array_push($users, $data->MAIN_UID);
}

$backUrl = $_SESSION['previous_location'];
unset($_SESSION['previous_location']);
//if(count)
switch ($act) {
	case 'FOLLOW':
		$sql = "INSERT INTO followers (MAIN_UID, F_UID, BLOCK_FLAG) VALUES (\"".$val."\",\"".$foo."\",TRUE);";
		//echo "$sql";
		mysqli_query($connection,$sql);
		//echo $backUrl;
		$_SESSION['message']="<p> You followed <a href='userprofile.php?user=".$valname."'>".$valname."</a></p>";
		header("Location:./".$backUrl);
		break;
	case 'Block':
		$sql = "INSERT INTO followers (MAIN_UID, F_UID, BLOCK_FLAG) VALUES (\"".$val."\",\"".$foo."\",FALSE);";
		//echo "$sql";
		mysqli_query($connection,$sql);

		header("Location:".$backUrl);
		break;
	case 'UNFOLLOW':
		$sql = "Delete from followers where MAIN_UID=\"".$val."\" and F_UID=\"".$foo."\"";
		mysqli_query($connection,$sql);
		header("Location:".$backUrl);
		break;
}/*
if ($_POST["block"]) {
	
}
else{

}
//if($val = $_POST['follow']){


//}*/
?>