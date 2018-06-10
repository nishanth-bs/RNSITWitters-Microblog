<?php
session_start();
include_once("method.php");
$tid = $_POST['tid'];
$sqlDeleteTweet = <<<a
	delete from tweets where tid = $tid;
a;

$connection = getConnectionToDb();
mysqli_query($connection,$sqlDeleteTweet);

$previous_page= $_SESSION['previous_loc'];
header("Location:".$previous_page."#".$tid);
?>