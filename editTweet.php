<?php
session_start();
include_once("method.php");
//include_once("functions.php");
 
$username = $_SESSION['uname'];
$body = substr($_POST['body'],0,140);
$tid= $_POST['tid'];
$connection = getConnectionToDb();
$uid = mysqli_query($connection,"Select uid from user_detail where user_name = '".$username."';");  //get the user id for the corresponding username
preg_match_all("/#\w+/", $body, $matches);
$UID = $_SESSION["uid"];

 $hashtagValues= array();
$i=0;
foreach ($matches as $value) {
	foreach ($value as $valuea) {
		$hashtagValues[$i] = $valuea;
		$i=$i+1;
	}
}
$sqlUpdateTweet = <<<r
	UPDATE tweets SET TWEET = '$body',time=now() WHERE tweets.TID = $tid;
r;

$result = mysqli_query($connection,$sqlUpdateTweet);

$previous_page= $_SESSION['previous_loc'];
header("Location:./".$previous_page);

?>