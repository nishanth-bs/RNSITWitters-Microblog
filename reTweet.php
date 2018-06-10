<?php
session_start();
include_once("method.php");
$tid = $_GET['tid'];
$_SESSION['tid']=$tid;
$retweet = retweet($_SESSION['tid'],$_SESSION['uid']);

//$hey1 = checkIfRetweetedOrNot($_SESSION['tid'],$_SESSION['uid']);
//if($hey1){?>
<!--	<a class="btn retweet" href="singleTweet.php?action=r"><span class="glyphicon glyphicon-retweet"></span></a> 	<?php
//}
//elseif(!$hey1){?>
	<a class="btn " href="singleTweet.php?action=r"><span class="glyphicon glyphicon-retweet"></span></a>-->	<?php
//}
$s =$_SESSION['tid'];
$previous_page= $_SESSION['previous_location'];
unset($_SESSION['previous_location']);
header("Location:./".$previous_page."#".$s);
?>