<?php
session_start();
include_once("method.php");
//include_once("functions.php");
 
$username = $_SESSION['uname'];
$connection = getConnectionToDb();
 
$uid = mysqli_query($connection,"Select uid from user_detail where user_name = '".$username."';");  //get the user id for the corresponding username


//$uid = mysqli_fetch_assoc($uid);
//echo "$uid[-1] $username $body ";
//$ud = mysqli_result($uid, 0,"UID"); 		//convert the result set into string , 0th row , column name in db is uid

 //INSERT INTO `tweets`(`UID`, `TWEET`, `TIME`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])
 $UID = $_SESSION["uid"];
if(isset($_POST['t'])){

$body = substr($_POST['body'],0,140);
 $hashtagValues= array();
preg_match_all("/#\w+/", $body, $matches);
$i=0;
foreach ($matches as $value) {
	foreach ($value as $valuea) {
		//$sqlHashtag =<<<INSERT
		//	insert into hashtag values()
		$hashtagValues[$i] = $valuea;
		
		//var_dump([$hashtagValues[$i]]);
		//echo "<br/>";
		$i=$i+1;
	}
	//break;
	//echo $value;
}
/*echo "$hashtagValues[0]";
foreach ($hashtagValues as $value) {
	# code...
	echo $value;
}*/
//date_default_timezone_set('asia/kolkata');
//echo date('h:i:s:u');
//$t = 0;
 $sql =<<<INSERT
insert into tweets (uid, tweet, time) values ($UID,'$body',now());
INSERT;
//echo "$t";
$result = mysqli_query($connection,$sql);


$sqlGetTid = <<<GET
select tid,time from tweets where tweet = '$body' order by time desc 
GET;
//order by because it takes the recent most tweet first, incase two tweets are identical
//without order by, any older tweet with the same body might get selected, so have done this way
$resGetTid = mysqli_query($connection,$sqlGetTid);
$tid = array();
$time=array();
$i=0;
$len = count($hashtagValues);	//this ensures that just the top values of 
//desc array(the most recent tweet,despite repeated copied tweets exists)
//echo "$len";
while($row = $resGetTid->fetch_assoc()){// && $i < $len){
	$tid[$i] = $row['tid'];
	$time[$i] = $row['time'];
	/*$sqlHashtag =<<<INSERT
	insert into hashtags values( '$tid','$hashtagValues[$i]','$time')
INSERT;

echo "$tid <br/> $hashtagValues[$i] <br/> $time<br/>";
	mysqli_query($connection,$sqlHashtag);*/
	$i +=1;
}

foreach ($hashtagValues as  $value) {
	# code...
	//echo "$value<br/>";
}
for($j=0;$j<$len;$j+=1){
	$sqlHashtag =<<<INSERT
	insert into hashtags values( '$tid[0]','$hashtagValues[$j]','$time[0]')
INSERT;

//echo "$tid[0] <br/> $hashtagValues[$j] <br/> $time[0]<br/>";
	mysqli_query($connection,$sqlHashtag);

}}

//add_post($userid,$body);
//$_SESSION['message'] = "Your post has been added! ";

if(isset($_POST['u'])){
	
 
 $targetfolder = "testupload/";
 
 $targetfolder = $targetfolder . mt_rand(10,100).basename( $_FILES['file']['name']);
 $connection = getConnectionToDb();
 
 $ok=1;
 
$file_type=$_FILES['file']['type'];
 
if ($file_type=="application/pdf" || $file_type=="image/gif" || $file_type=="image/jpeg") {
 
 if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))
 
 {
 
 echo "The file ". basename( $_FILES['file']['name']). " is uploaded";

 $sql =<<<a
INSERT INTO `tweets`( UID, TWEET, LINK, TIME) VALUES ($UID,'Notes ','$targetfolder',now());
a;
mysqli_query($connection,$sql);
 }
 
 else {
 
 echo "Problem uploading file";
 
 }
 
}
 
else {
 
 echo "You may only upload PDFs, JPEGs or GIF files.<br>";
 
}
}

//echo var_dump($matches);
 
header("Location:login1.php");
?>