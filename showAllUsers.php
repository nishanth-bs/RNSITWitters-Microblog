<?php
session_start();
include_once("method.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Twitter</title>
    
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
<?php showNavigationBar(1);?> <br>
<span class="h4 strong"><strong>Who to follow?</strong></span><br><br>
<?php
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    $users = suggestAllUser($_SESSION['uid']);
    if (count($users)) {    ?>
        <?php
        foreach ($users as $key => $value) {
                /*echo "<tr valign='top'>\n";
                echo "<td>" . $value['name'] . "</td>";
                echo "<td><a href=\"./userprofile.php?user=" . $value['uname'] . "\">" . $value['uname'] . "</a></td>\n";
            }
            echo "</table>";*//*
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
                */?>
                <div class="well col-lg-3 col-md-4 col-sm-6 ">
                    
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img src="default_profile_pic.png" class="media-object makeItRound">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="userprofile.php?user=<?php echo $value['uname']; ?>"><?php echo $value['name']; ?></a> </h4>
                            <small><i>@<?php echo $value['uname']; ?></i></small><br>
                            <strong><font color="#9d9d9d"><?php echo ($value['totalFollowers']-1)." followers"?></font></strong><br><br>
                            <?php $_SESSION['previous_location']= "showAllUsers.php" ?>
                            <form method="post" action="followorblock.php">
                                <input type="hidden" name="fid" value="<?php echo $value['ud']?>">
                                <input type="hidden" name="fname" value="<?php echo $value['uname'];?>">
                                <input type = "submit" name="act" value="FOLLOW" class="btn btn-info "></input>
                                <!--<input type="submit" name="act" value="FOLLOW" class="btn btn-default">-->
                            </form>
                        </div>

                </div>
            </div>
                <?php }} ?></div></div></body></html>
