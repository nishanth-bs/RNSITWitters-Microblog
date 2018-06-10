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
                        <li><a href="#">My Profile<span class="badge">Upcoming</span></a></li>
                        <li><a href="#">Settings<span class="badge">Upcoming</span></a></li>
                        <li><a href="logout.php">Logout</a></li>
                        <li class="divider"></li>
                        <li><a href="dev.php">About the developer</a></li>
                    </ul>
                    </div>
                    
                </li>
            </ul>
		</div><!-- navbar-collapse-->
	</nav>

</div>

<?php
if(isset($_GET["user"])){
	$user = $_GET["user"];

	$connection = getConnectionToDb();
	$val = mysqli_query($connection,"Select uid from user_detail where user_name = '".$user."';");  //get the user id for the corresponding username
	while($data= mysqli_fetch_object($val)){
		$uid = $data->uid;						//getting the string from resultset object
		//echo "$uid";
		
	}
	//echo ($val["uid"]);
?>
<form action = "followorblock.php">
	
</form>
<?php
	$connection = getConnectionToDb();
	?>
	<div class="jumbotron">
	<?php
	echo "<h2 class=\"username center-block\">".$user."</h2>";


//	echo "<h4><a href='#follow'>Follow</a></h4>";
//	echo "<h4><a href='#'>Block</a></h4>";

?>
<?php $_SESSION['previous_location']="userprofile.php?user=".$user ;?>
<form method="post" action ="followorblock.php">
	<?php
	$sql2 = "Select MAIN_UID from followers where MAIN_UID=\"".$uid."\" and F_UID=\"".$_SESSION["uid"]."\" and BLOCK_FLAG=true";
	//prepare sql statement , pass it inside the below mysqli_query function, 
	$res2 = mysqli_query($connection,$sql2);
	//this executes the query and returns the  resultset
	$following = mysqli_num_rows($res2);//cthis function checks the number of rows in the returned resultset object
	switch ($following) {		//my code logic DONT worry
		case '0':
			$temp = "FOLLOW";
			break;
		default:
			$temp = "UNFOLLOW";
			break;
	}
	echo "<input class='btn btn-default center-block' type=\"submit\" name=\"act\" value=".$temp.">";
	
	?>

	<!--<input class='' type="submit" name="act" value= "Block">-->		<!-- This gives a submit button, on clicking this it 
	goes to file in the action field mentioned in the form action above-->
	
<?php echo "<input type=\"hidden\" name= \"fname\" value= \"". $user."\">";
echo "<input type = \"hidden\" name= \"fid\" value =\"".$uid."\">";

	$posts = showCurUserT($uid);
	$tidArr = getAllTweetsWhichTheCurrentUserHasLiked($_SESSION['uid']);
	$rtidArr = getAllTweetsWhichTheCurrentUserHasRetweeted($_SESSION['uid']);
	var_dump($tidArr);
?>
</form>
</div>
<!--
<a name="follow">execute
<?php
	//$sql = "INSERT INTO followers (MAIN_UID, F_UID, BLOCK_FLAG) VALUES (\"".$user."\",\"".$_SESSION["uid"]."\",TRUE);";
//mysqli_query($connection,$sql);

?>
	
</a>-->
<div class="row">
	<div class="col-md-3">
		<div class="well">
			
		</div>
	</div>
	<div class="col-md-8">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#tweet"  data-toggle="tab">Tweets</a></li>
		  <li><a href="#followers" data-toggle="tab">Followers</a></li>
		  <li><a href="#following" data-toggle="tab">Following</a></li>
		  <li><a href="#likes" data-toggle="tab">Likes</a></li>
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          <?php //if($following){
              if (count($posts)){?>
                
              
                    <?php   $_SESSION['previous_location']='userprofile.php?user='.$user;
                      foreach ($posts as $key => $list) { ?>        
                  <div class="well">
                    <div class="media">
                      <div class="media-left">
                        <a href="#">
                          <img src="default_profile_pic.png" class="media-object makeItRound">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="userprofile.php?user=<?php echo $list['uname']; ?>"><?php echo $list['name']; ?></a> </h4>
                        <small><i> @<?php echo "<strong>".$list['uname']."</strong><br>"; echo $list['time'];  ?></i></small>
                        <p id= <?php echo $list['tid'];?>> <?php echo $list['body']; ?></p>
                        
                        <?php $_SESSION['tid']=$list['tid'];
                        $flag = false;
                        foreach ($tidArr as $key => $value) {
                          if(in_array($_SESSION['tid'], $value)){?>
                            <a class="btn like" href="likeTweet.php?tid=<?php echo $list['tid'];?>" ><span class="glyphicon glyphicon-heart"></span></a><?php
                            $flag=true;
                            break;
                          }
                        }
                        if(!$flag){?>
                          <a class="btn like" href="likeTweet.php?tid=<?php echo $list['tid'];?>" ><span class="glyphicon glyphicon-heart-empty"></span></a><?php
                        }/*echo $_SESSION['tid'];*/ echo $list['likes'];
                        $flag = false;
                        foreach ($rtidArr as $key => $value) {
                          if(in_array($_SESSION['tid'], $value)){?>
                            <a class="btn retweet" href="reTweet.php?tid=<?php echo $list['tid'];?>"><span class="glyphicon glyphicon-retweet"></span></a><?php
                            $flag=true;
                            break;
                          }
                        }
                        if(!$flag){?>
                          <a class="btn notRetweeted " href="reTweet.php?tid=<?php echo $list['tid']; ?>"><span class="glyphicon glyphicon-retweet"></span></a><?php
                        }
                        echo $list['retweet'];?>  
                      </div>
                    </div>
                  </div>
                <?php
                //}
              }
              //else{
                //echo  ($user." has not posted anything yet!");
                        //echo 'Empty newsfeed. :P Start tweeting and following people! ';
              //}?>
        
            
            <?php
          }
          ?>
        

    </div>
			<div class="tab-pane fade" id="followers">folllowers</div>

			<div class="tab-pane fade" id="following">follloweing</div>

			<div class="tab-pane fade in active" id="likes">
				<div class="col-md-8">
					<?php if($following){
							if (count($posts)){?>
    				    
							
		        				<?php  	$_SESSION['previous_location']='userprofile.php?user='.$user;
		           				foreach ($posts as $key => $list) {	?>				
									<div class="well">
										<div class="media">
											<div class="media-left">
												<a href="#">
													<img src="default_profile_pic.png" class="media-object makeItRound">
												</a>
											</div>
											<div class="media-body">
												<h4 class="media-heading"><a href="userprofile.php?user=<?php echo $list['uname']; ?>"><?php echo $list['name']; ?></a> </h4>
												<small><i> @<?php echo "<strong>".$list['uname']."</strong><br>"; echo $list['time'];  ?></i></small>
												<p id= <?php echo $list['tid'];?>> <?php echo $list['body']; ?></p>
												<!--<a class="btn btn-default like" href="likeTweet.php?tid=<?php echo $list['tid'];?>"></a><?php/*singleTweet.php?tid=<?php echo 	$list['tid'];?>&action=l" ></a>*/?>-->
												<?php $_SESSION['tid']=$list['tid'];
												$flag = false;
												foreach ($tidArr as $key => $value) {
													if(in_array($_SESSION['tid'], $value)){?>
														<a class="btn like" href="likeTweet.php?tid=<?php echo $list['tid'];?>" ><span class="glyphicon glyphicon-heart"></span></a><?php
														$flag=true;
														break;
													}
												}
												if(!$flag){?>
													<a class="btn like" href="likeTweet.php?tid=<?php echo $list['tid'];?>" ><span class="glyphicon glyphicon-heart-empty"></span></a><?php
												}/*echo $_SESSION['tid'];*/ echo $list['likes'];
												$flag = false;
												foreach ($rtidArr as $key => $value) {
													if(in_array($_SESSION['tid'], $value)){?>
														<a class="btn retweet" href="reTweet.php?tid=<?php echo $list['tid'];?>"><span class="glyphicon glyphicon-retweet"></span></a><?php
														$flag=true;
														break;
													}
												}
												if(!$flag){?>
													<a class="btn notRetweeted " href="reTweet.php?tid=<?php echo $list['tid']; ?>"><span class="glyphicon glyphicon-retweet"></span></a><?php
												}
												echo $list['retweet'];?>	
											</div>
										</div>
									</div>
				 				<?php
				 				}
							}
							else{
								echo  ($user." has not posted anything yet!");
                				//echo 'Empty newsfeed. :P Start tweeting and following people! ';
							}?>
				
						</div>
						<?php
					}
					else{
						echo "<strong><h2>you arent following the user</h2></strong>";
					}?>
				</div>

			</div>
		</div>
	<?php } ?>
</div>



<br/><!--
<a href="./login1.php">Go back to my profile</a>-->