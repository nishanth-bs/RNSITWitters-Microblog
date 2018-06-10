<?php
session_start();
include_once("method.php");
$tid = $_GET['tid'];
$_SESSION['tid']=$tid;
$hi = likeOrUnlikeTheTweet($_SESSION['tid'],$_SESSION['uid']);
$s =$_SESSION['tid'];
$previous_page= $_SESSION['previous_location'];
unset($_SESSION['previous_location']);
header("Location:./".$previous_page."#".$s);
?>