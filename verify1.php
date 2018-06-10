<?php
include_once("method.php");

if(isset($_SESSION['logged_in'])):
	if ($_SESSION['logged_in'] != true)://not previously logged in,if logged in no need to check if the username and password exists in the db
        if(isset($_POST['name']) && isset($_POST['password'])):
            $connection = getConnectionToDb();
            $username   = mysqli_real_escape_string($connection,$_POST["name"]);
            $password   = mysqli_real_escape_string($connection,$_POST["password"]);
            $res    = mysqli_query($connection, "Select user_name, password From nishanth.USER_DETAIL where user_name= '" . $username . "' and password = '" . $password . "' ;");
            $number = mysqli_num_rows($res);
            if ($number >0):
                $_SESSION["logged_in"] = true;
                $_SESSION["uname"]     = $username;
                $uid = mysqli_query($connection, "Select uid,name from user_detail where user_name = '" . $username . "';"); //get the user id for the corresponding username
                while ($gg = $uid->fetch_assoc()):
                                $_SESSION["uid"] = $gg['uid'];
                                $_SESSION['name']=$gg['name'];
                                break;
    	        endwhile; 
    	        header("Location:login1.php");
        	else:
	            $_SESSION["invalidUorP"] = "The username or password is invalid".$username.$password;
	            header("Location:index.php");
	            exit();
	        endif;
	    else: 
            $_SESSION["invalidUorP"] = "The username or password is not entered";
            header("Location:index.php");
            exit();
        endif;
	elseif($_SESSION['logged_in'] == true):
        header("Location:login1.php");
    endif;
else:
	header("Location:index.php");
endif;


?>
