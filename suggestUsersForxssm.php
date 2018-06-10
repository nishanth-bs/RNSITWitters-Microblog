<?php
session_start();
include_once("method.php");
?>

<!DOCTYPE html>
<html lang="en">
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
        right: 30;        }
    </style>
    <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS 
        <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>-->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="customizedStyleSheet.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<body>
<div class="container">
<?php showNavigationBar(1); ?><br><br>
<div class="col-md-3 visible-xs visible-sm"><!--third column of large lg page-->
            <br>
            <div class="well">
                <span class="h4 strong"><strong>Who to follow?</strong></span><a href="showAllUsers.php"> view all</a><br><br>
                <?php
                $users = suggestNewUsers($_SESSION['uid']);
                if (count($users)) {    ?>
            
                    <table class="table" border="1" cellspacing="0" cellpadding="5" width="500">
                    <?php
                    foreach ($users as $key => $value) {
                        /*echo "<tr valign='top'>\n";
                        echo "<td>" . $value['name'] . "</td>";
                        echo "<td><a href=\"./userprofile.php?user=" . $value['uname'] . "\">" . $value['uname'] . "</a></td>\n";
                    }
                    echo "</table>";*/
                        ?>
                        <ul class="list-group col-xs-7">

                            <dl>
                                <dt><strong><?php echo $value['name']; ?></strong></dt>
                                <dd><?php echo "<a href=\"./userprofile.php?user=" . $value['uname'] . "\">" ."@". $value['uname'] . "</a>";?></dd>
                            </dl>
                            <hr>
                        </ul>
                        <ul class="col-xs-5">
                            <form method="post" action="followorblock.php">
                                <input type="hidden" name="fid" value="<?php echo $value['ud']?>">
                                <input type="hidden" name="fname" value="<?php echo $value['uname'];?>">
                                <input type = "submit" name="act" value="FOLLOW" class="btn btn-info "></input>
                                <!--<input type="submit" name="act" value="FOLLOW" class="btn btn-default">-->
                            </form>
                        </ul>
                        <?php
                    }
                }
                else{
                echo "no other users yet! ";
                }   ?>
            </div> <!--close of who to follow well -->
                    
        </div>