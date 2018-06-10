<?php
session_start();
include_once("method.php");
$hashtags = getMostUsedHashtags();
//var_dump($hashtags);
if(count($hashtags)){
	foreach ($hashtags as $key => $value) {
		//var_dump($value);
		echo $value['hash'].$value['coun'];
	}
}

?>