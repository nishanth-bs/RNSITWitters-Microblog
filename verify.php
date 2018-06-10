<?php
session_start();
include_once("method.php");
?>
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

				header("Location:login1.php");                
        	} 
        	else{
	            //echo "alert(\"The username or password is invalid\")";
	            $_SESSION["invalidUorP"] = "The username or password is invalid";
	            header("Location:index.php");
	        }
		}
?>