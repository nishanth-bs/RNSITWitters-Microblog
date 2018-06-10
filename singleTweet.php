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

				<li><a href = "userprofile.php?user=<?php echo $_SESSION["uname"]; ?>"><strong><em><?php echo $_SESSION["uname"]; ?></em></strong></a></li>
				<li>
					<a data-toggle="collapse" class="btn dropdown-toggle img-circle" id="user-dropdown-toggle" data-placement="bottom" rel="noopener" role="button" aria-haspopup="true" data-original-title="Profile and settings">
						<img src="default_profile_pic.png">
					</a>
				</li>
				<li><a href = "aboutTheDev.php">About</a></li>

				<li><a href = "logout.php">Logout</a></li>
			</ul>
		</div><!-- navbar-collapse-->
	</nav>
</div>

<?php 
/*if(isset($_SESSION['tid'])){
	$currenttid = $_SESSION['tid'];
	unset($_SESSION['tid']);
}*/
if(isset($_GET['tid'])){
$tid = $_GET['tid'];
$_SESSION['tid']=$tid;
}

$action = $_GET['action'];
if ($action =='l') {
	$hi = likeOrUnlikeTheTweet($_SESSION['tid'],$_SESSION['uid']);
}
elseif ($action == 'r') {
	$retweet = retweet($_SESSION['tid'],$_SESSION['uid']);
}

$hey = checkIfLikedOrNot($_SESSION['tid'],$_SESSION['uid']);
$hey1 = checkIfRetweetedOrNot($_SESSION['tid'],$_SESSION['uid']);
$thisTweet = getCurTweet($_SESSION['tid']);

//$mainAction = $_GET['mainAction'];// L/R-----can be L/R like/retweet
//$subAction= $_GET['subAction'];	// L/D----- needed if the main action is like(L)- can either be like or dislike L/D

if(count($thisTweet)){
	foreach ($thisTweet as $key => $list) {
		# code...
		?>
		<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="well">
								<div class="media">
									<div class="media-left">
										<a href="#">
											<img src="default_profile_pic.png" class="media-object">
										</a>
									</div>
									<div class="media-body">
										<h4 class="media-heading"><a href="userprofile.php?user=<?php echo $list['uname']; ?>"><?php echo $list['name']; ?></a> </h4>
										<small><i> @<?php echo "<strong>".$list['uname']."</strong><br>"; echo $list['time'];  ?></i></small>
										<p > <?php echo $list['tweet']; ?></p>

										<?php/*
										switch ($mainAction) {
											case 'L':
												likeOrUnlikeTheTweet($_SESSION['tid'],$_SESSION['uid']); //needed to set the button design in the front end

												break;
											
											case 'R':

												break;
											default:
												# code...
												//redirect to error page
												break;
										}*/
										?>
										<?php 
										if($action='l'){
											if($hey){?>
												<a class="btn like" href="singleTweet.php?action=l" ><span class="glyphicon glyphicon-heart"></span></a> 	<?php
											}
											elseif(!$hey){?>
												<a class="btn like" href="singleTweet.php?action=l" ><span class="glyphicon glyphicon-heart-empty"></span></a>	<?php
											}
											else{
												//do nothing
											}
										}
										
										if($action='r'){
											if($hey1){?>
												<a class="btn retweet" href="singleTweet.php?action=r"><span class="glyphicon glyphicon-retweet"></span></a> 	<?php
											}
											elseif(!$hey1){?>
												<a class="btn " href="singleTweet.php?action=r"><span class="glyphicon glyphicon-retweet"></span></a>	<?php
											}
											else{
												//do nothing
											}
										}

										/*if(){ ?>
										
        									
										<?php }
										else{ ?>
											
        									
										<?php  } */?>
										 <?php  echo $list['likes'];?>
										 
										 <?php

										 ?>
										<a href="login1.php"><span class="glyphicon glyphicon-cirle-arrow-left"></span></a>
									</div>
								</div>
							</div>
						</div>

					</div>
 
		<?php
	}
}
echo $_SESSION['tid'];
?>
</div>


</body></html>