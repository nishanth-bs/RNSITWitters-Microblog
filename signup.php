<?php 
session_start();
include_once("method.php");
$connection = getConnectionToDb();
include_once("queries.php");
?>
<html>
<head>
	<title>Twitter</title>
	<style type="text/css">
	h1{
		text-align: center;
		background: #1DA1F2;
		color: white;
	}
	.tweett{
		align-items: center;
	}
	.logout{
		position: absolute;
		top: 15;
		right: 30;		}
	</style>

</head>

<body>
	<?php
	if($_POST['password']!=$_POST['retypedpassword']){
		$_SESSION["message"] = "The typed passwords don't match!";
		header("Location:signupnow.php");
		exit();
	}
	if(strlen($_POST['password'])<7){
		$_SESSION["message"] = "Make sure the password has more than 6 characters!";
		header("Location:signupnow.php");
		exit();
	}
	//if($_SESSION['logged_in'] == false ){
	//if not logged in, create an account, to avoid multiple signups simultaneously(using signup url multiple times)

		$username = $_POST['username'];
		$sql2 = "select USER_NAME from user_detail where USER_NAME=\"".$username."\"";
		$res = mysqli_query($connection,$sql2);
		if(mysqli_num_rows($res)>0){
			$_SESSION["message"] = "The username alreadyexists, please choose a different username";
			header("Location:signupnow.php");
			exit();
		}


		$name = $_POST['name'];
		$password = $_POST['password'];
		$dob = $_POST['dob'];
		$phoneno = $_POST['phone'];
		$signupQry = "INSERT INTO `user_detail`(`NAME`, `USER_NAME`, `PASSWORD`, `DOB`, `PHONE_NO`) VALUES ('".$name."','".$username."','".$password."','".$dob."',".$phoneno.");";

		$addUser = mysqli_query($connection,$signupQry);
		$followHimself = <<<INSERT
	insert into followers values ($uid,$uid,1)
INSERT;
	mysqli_query($connection,$followHimself);

$_SESSION['successCreation']='Account created successfully, please log in.';
header("Location:index.php");
		//$_SESSION["uname"] = $username;

		//$res = mysqli_query($connection,"Select user_name, password From nishanth.USER_DETAIL where user_name= '".$username."' and password = '".$password."' ;");
		//$number = mysqli_num_rows($res);
		//if( $number>0 ){
		//	$_SESSION["logged_in"] = true;
		//	$_SESSION["uname"] = $username;
		//	echo 'logged in '.$_SESSION["uname"];
		//$uid = mysqli_query($connection,"Select uid from user_detail where user_name = '".$username."';"); */ //get the user id for the corresponding username
		/*while ($gg = $uid->fetch_assoc()) {
    		//echo $gg['uid']."<br/>";
			$_SESSION["uid"]=$gg['uid'];
			break;
		}*/
	

	/**if($connection-> $addUser == true){
		echo ' new user added';

	}
	else{
		echo "Error".$connection->error;
	}*/
	//echo "mysqli_affected_rows()";
	//mysqli_commit($connection);
	//echo "<h4> You are now signed up</h4>";
	//$uid = $_SESSION["uid"];
	

//else{
//	echo 'You are already logged in';

//}
//$_SESSION["logged_in"] = true;
//showTweetBox();?>

<!--<div class="logout">-->
<?php //showLogoutButton();		
?></div> <?php
//if (isset($_SESSION['message'])){
//	echo "<b>". $_SESSION['message']."</b>";
//	unset($_SESSION['message']);


/*
echo "<br/><br/><br/><h3>Tweets tuned according to your preference sorted by time<br/><h3>";
$posts = show_posts($_SESSION["uid"]);
if(count($posts)){
	?>
	<table border="1" cellspacing="0" cellpadding="5" width="500">
	<?php
	foreach ($posts as $key => $list) {
			# code...
		echo "<tr valign='top'>\n";
		echo "<td>".$list['uid']."</td>\n";
		echo "<td>".$list['body']."<br/>\n";
		echo "<small>".$list['time']."</small></td>\n";
		echo "</tr>";
	}
	?>
	</table>
	<?php
}
else{
	echo '<h3>you have not posted anything yet!<h3>';
}
?>
<br/><br/><br/><h3>USERS</h3>	
<?php
echo "<h3> <bold>Users you are following</bold></h3>";
$users = showFollowing($_SESSION["uid"]);
if(count($users)){
	?>
	<table border="1" cellspacing="0" cellpadding="5" width="500">
	<?php
	foreach ($users as $key => $value) {
				# code...
		echo "<tr valign='top'>\n";
		echo "<td>".$value['uid']."</td>";
		echo "<td><a href=\"./userprofile.php?user=".$value['user_name']."\">".$value['user_name']."</a></td>\n";
	}
	echo "</table>";
}
else{
	echo "no other users on the system! ";
}
?>
<br/>
<h1> all users</h1>

<?php
echo "";
$users = showAllUsers();
if(count($users)){
	?>
	<table border="1" cellspacing="0" cellpadding="5" width="500">
	<?php
	foreach ($users as $key => $value) {
				# code...
		echo "<tr valign='top'>\n";
		echo "<td>".$value['uid']."</td>";
		echo "<td><a href=\"./userprofile.php?user=".$value['user_name']."\">".$value['user_name']."</a></td>\n";
	}
	echo "</table>";
}
else{
	echo "no other users on the system! ";
}
*/
?>





</body>
</html>