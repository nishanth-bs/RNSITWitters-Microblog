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
<div class="row">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="navbar-header">
            
<a href="login1.php" class="navbar-brand"><span class="glyphicon glyphicon-arrow-left restrictGlyphicon"></span></a>
            <a class="navbar-brand"><strong>RNSIT Witters</strong></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#square">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div> <!--navbar-header-->
        <div class="navbar-collapse collapse" id="square">
            <ul class="nav navbar-nav navbar-right">
                <!--<li><a href = "userprofile.php?user=<?php echo $_SESSION["uname"]; ?>"><strong><em><?php echo $_SESSION["uname"]; ?></em></strong></a></li>-->
                <li><a href="login1.php"><span class="glyphicon glyphicon-home restrictGlyphicon"></span></a></li>
                <li>
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="btn dropdown-toggle" id="user-dropdown-toggle" data-placement="bottom" rel="noopener" role="button" aria-haspopup="true" data-original-title="Profile and settings">
                        <img class = "makeItRound restrictImageSize" src="default_profile_pic.png">
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header"><strong><b><h4><?php echo $_SESSION['name']."<br/><i><h5>".$_SESSION['uname'];?></h5></i> </h4></b></strong></li>
                        <li class="divider visible-xs visible-sm"></li>
                        

<li class="visible-xs visible-sm"><a href="hashtagForxssm.php">Hashtags</a></li>
                        <li class="visible-xs visible-sm"><a href="suggestUsersForxssm.php">Suggested users</a></li>
                        <li class="divider"></li>
                        <li><a href="#">My Profile</a></li>
                        <li><a href="#">Settings</a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li class="divider"></li>
                        <li><a href="#">About the developer</a></li>
                    </ul>
                    </div>
                    
                </li>
            </ul>
        </div><!-- navbar-collapse-->
    </nav>
</div><div class="row">
    <div class="col-xs-12">
        <div class="col-md-3 visible-sm visible-xs">
            <span class="h3">Most used hashtags </span> 
            <div class="dropdown">
                <a href="#" class="dropdown-toggle btn btn-info" data-toggle="dropdown"> time<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="disabled"><a href="#">in past one day</a></li>

                    <li class="active"><a href="hashtagCompute.php">since the start of time</a></li>
                </ul>
            </div>
            <div class="list-group"><?php
                $hashtags = getMostUsedHashtags();
                if(count($hashtags)){
                    foreach ($hashtags as $key => $value) {?>
                    <dl class="list-group-item">
                        <dt><a href="hashtags.php?hash=<?php echo substr($value['hash'], 1); ?>"><?php echo $value['hash'];?></a></dt>
                        <dd><?php echo $value['coun']; ?> times</dd>
                    </dl><?php
                    }
                }?>
                
            </div>
        </div>
    </div>
</div>
</div>
</body></html>

