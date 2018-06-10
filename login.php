

<?php
session_start();
include_once("method.php");
?>
<!doctype html>
<html lang="en">
<head><title>Twitter</title>
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
        right: 30;        }
    </style>
    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>


<body>

<header><h1>RNSIT Witter</h1></header>

		<?php
		if ($_SESSION['logged_in'] != true) { //not previously logged in,if logged in no need to check if the username and password exists in the db
                
            $username   = $_POST["name"];
            $password   = $_POST["password"];
            $connection = getConnectionToDb();
            
            $res    = mysqli_query($connection, "Select user_name, password From nishanth.USER_DETAIL where user_name= '" . $username . "' and password = '" . $password . "' ;");
            $number = mysqli_num_rows($res);
            if ($number > 0) {
                $_SESSION["logged_in"] = true;
                $_SESSION["uname"]     = $username;
                echo 'logged in as' . $_SESSION["uname"];
                $uid = mysqli_query($connection, "Select uid from user_detail where user_name = '" . $username . "';"); //get the user id for the corresponding username
                while ($gg = $uid->fetch_assoc()) {
                                //echo $gg['uid']."<br/>";
                                $_SESSION["uid"] = $gg['uid'];
                                break;
    	        }
                                
        	} 
        	else{
	            //echo "alert(\"The username or password is invalid\")";
	            $_SESSION["invalidUorP"] = "The username or password is invalid";
	            header("Location:index.php");
	        }
		}
		?>
		<div class="container">
	<div class = "row">
	   <div class="col-lg-offset-4 col-lg-4">
		<?php
		showTweetBox();
		?>		
		
    <div class="logout">

	<?php
	showLogoutButton();
	?>	
	</div> </div>
	</div>
	<?php
	if (isset($_SESSION['message'])) {
        echo "<b>" . $_SESSION['message'] . "</b>";
        unset($_SESSION['message']);
	}

	?>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4">
		<?php
		echo "<br/><br/><br/><h3>Tweets tuned according to your preference <br/></h3>";
		$posts = show_posts($_SESSION["uid"]);
		if (count($posts)) {
		?>
           <table class = "table" border="1" cellspacing="0" cellpadding="5" width="500">
        	<?php
            foreach ($posts as $key => $list) {
                # code...
                echo "<tr valign='top'>\n";
                echo "<td>" . $list['uid'] . "</td>\n";
                echo "<td>" . $list['body'] . "<br/>\n";
                echo "<small>" . $list['time'] . "</small></td>\n";
                echo "</tr>";
				echo <<<I
				</table>
I;
			}
			
			} else {
                echo 'you have not posted anything yet!';
}
?>
   <br/><br/><br/><h3>USERS</h3>   
   </div>
   
   <div class="col-lg-4"> 
    <?php
echo "<h3> <bold>Users you are following</bold></h3>";
$users = showFollowing($_SESSION["uid"]);
if (count($users)) {
?>
           <table border="1" cellspacing="0" cellpadding="5" width="500">
                <?php
                foreach ($users as $key => $value) {
                                # code...
                                echo "<tr valign='top'>\n";
                                echo "<td>" . $value['uid'] . "</td>";
                                echo "<td><a href=\"./userprofile.php?user=" . $value['user_name'] . "\">" . $value['user_name'] . "</a></td>\n";
                }
                echo "</table>";
} else {
                echo "no other users on the system! ";
}
?>
</div>
</div>
    <h1> all users</h1>

    <?php
echo "";
$users = showAllUsers();
if (count($users)) {
?>
           <table class="table" border="1" cellspacing="0" cellpadding="5" width="500">
                <?php
                foreach ($users as $key => $value) {
                                # code...
                                echo "<tr valign='top'>\n";
                                echo "<td>" . $value['uid'] . "</td>";
                                echo "<td><a href=\"./userprofile.php?user=" . $value['user_name'] . "\">" . $value['user_name'] . "</a></td>\n";
                }
                echo "</table>";
} else {
                echo "no other users on the system! ";
}


?>
</div>


</body>
</html>