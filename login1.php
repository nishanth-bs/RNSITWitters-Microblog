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
	<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>-->


<?php 
/**
* Check if the login credentials are valid
* if valid, do nothing, this page gets displayed
* else, redirect to the index page 
* setting the error message $_SESSION["invalidunameorp"]
*/
?>
<?php
/**/
		if ($_SESSION['logged_in'] != true)://not previously logged in,if logged in no need to check if the username and password exists in the db
            //if(isset($_POST['name']) && isset($_POST['password'])):

	            $connection = getConnectionToDb();
	            $username   = mysqli_real_escape_string($connection,$_POST["name"]);
	            $password   = mysqli_real_escape_string($connection,$_POST["password"]);
	            
	            $res    = mysqli_query($connection, "Select user_name, password From USER_DETAIL where user_name= '" . $username . "' and password = '" . $password . "' ;");
	            $number = mysqli_num_rows($res);
	            if ($number ==1):
	                $_SESSION["logged_in"] = true;
	                $_SESSION["uname"]     = $username;
	                $uid = mysqli_query($connection, "Select uid,name from user_detail where user_name = '" . $username . "';"); //get the user id for the corresponding username
	                while ($gg = $uid->fetch_assoc()):
	                                $_SESSION["uid"] = $gg['uid'];
	                                $_SESSION['name']=$gg['name'];
	                                break;
	    	        endwhile; 
	        	else:
		            $_SESSION["invalidUorP"] = "The username or password is invalid";
		            header("Location:index.php");
		            exit();
		        endif;
		    /*else: 
	            $_SESSION["invalidUorP"] = "The username or password is not entered";
	            header("Location:index.php");
	            exit();
	        */
	        
	        endif;

		//else:
          //  header("Location:login1.php");
        //endif;
/**/
/*if(!isset($_SESSION['login1'])){
    $_SESSION['login1'] = 1;
    include 'verify1.php';
}*/
?>


<div class="container">
<?php 
 showNavigationBar(0);
 ?>

<div class="row">
	<div class="col-xs-12">
		<div class="col-md-3 hidden-xs hidden-sm">
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
		<div class="col-md-6">
			<div class="row">
				<div class="col-xs-12">
					<div class="well">
						<form  class="form-group" method="post" action="tweet.php"<?php unset($_SESSION['login1']); ?>>
							<label class="control-label"><h4><strong>Compose new Tweet</strong></h4></label>
							<textarea class = "form-control" placeholder="What's up RNSIT?" name='body' rows='3' cols='50'  maxlength='140' required></textarea>
							<br>
							<p><input class = "form-control btn btn-primary" type='submit' value='Tweet' name="t" /></p>
						
						</form>
					</div> <!-- well for tweet input-->
					<span class="h2 col-xs-offset-5">or</span>
					<div class="well">
						<form action="tweet.php" class="form-group" method="post" enctype="multipart/form-data">

							<label class="control-label"><h4><strong>Upload notes</strong></h4></label>
							<input type="file"   name="file" size="50" required="true" /> <br/>
							<input type="submit" class="form-control btn btn-primary" value="Upload" name="u" />
 
						</form>
					</div>
 

				</div>
				
			</div>
			<div class="row">
				<div class="col-xs-12">
					<?php
					$posts = show_posts($_SESSION["uid"]);
					$tidArr = getAllTidWhichTheCurrentUserHasLiked($_SESSION['uid']);
					$rtidArr = getAllTidWhichTheCurrentUserHasRetweeted($_SESSION['uid']);
					if (count($posts)) {	?>
       			   		<?php
						$_SESSION['previous_location']='login1.php';
						$_SESSION['previous_loc']='login1.php';
		            	foreach ($posts as $key => $list) {
							$cur = $list['tid'];?>	
							<div class="well">
								<div class="media">
									<div class="media-left">
										<a href="#">
											<img src="default_profile_pic.png" class="media-object makeItRound">
										</a>
									</div>

									<div class="media-body">
											<h4 class="media-heading dropdown">
												<a href="userprofile.php?user=<?php echo $list['uname']; ?>"><?php echo $list['name']; ?></a> 
												<?php if($_SESSION['uid']==$list['uid']): ?>
												<a class="dropdown-toggle pull-right" data-toggle="dropdown"><button class="btn btn-default transparent-border-for-button"><span class="caret"></span></button></a>
												<?php endif; ?>
												<ul class="dropdown-menu pull-right">
													<li><a href="#" data-toggle="modal" data-target="#editModal">edit</a></li>
													<li><a href="#" data-toggle="modal" data-target="#deleteModal">delete</a></li>
													<li><a href="#">mute notifications</a></li>
												</ul>
											</h4>
											<div id="editModal" class="modal fade" role="dialog">
  												<div class="modal-dialog">
													<!-- Modal content-->
												    <div class="modal-content">
												      	<div class="modal-header">
												        	<button type="button" class="close" data-dismiss="modal">&times;</button>
												        	<h4 class="modal-title">Edit tweet</h4>
												      	</div>
												      	<div class="modal-body">
												      		<form class="form-group" action="editTweet.php" method="post">
												      		
																<textarea class = "form-control"  name='body' rows='3' cols='50'  maxlength='140' ><?php echo $list['body'];?></textarea>
																<br>
																<input type="hidden" name="tid" value="<?php echo $list['tid']; ?>">
																<p><input class = "form-control btn btn-primary" type='submit' value='Edit tweet' /></p>
																
												      		</form>
												      	</div>
												    <div class="modal-footer">

												     	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												    </div>
												</div>
											</div>	
										</div>
										<div id="deleteModal" class="modal fade" role="dialog">
  												<div class="modal-dialog">
													<!-- Modal content-->
												    <div class="modal-content">
												      	<div class="modal-header">
												        	<button type="button" class="close" data-dismiss="modal">&times;</button>
												        	<h3 class="modal-title">Delete tweet?</h3>
												      	</div>
												      	<div class="modal-body">
												      		<form class="form-group" action="deleteTweet.php" method="post">
												      		
																
																<input type="hidden" name="tid" value="<?php echo $list['tid']; ?>">
																<h4 >Are you sure you want to delete tweet?</h4>
																<div class="inline">

																	<button type="submit"  class="btn btn-default " >Yes</button>
												     			<button type="button" class="btn btn-default " data-dismiss="modal">No</button>

																</div>
												     			
												      		</form>
												      	</div>
												    </div>
											</div>
											
										</div>
										<small><i> @<?php echo "<strong>".$list['uname']."</strong><br>";
										/*$time=strtotime($list['time']); 
										echo date('d-m-y',$time);*/ 
										echo $list['time'];  ?></i></small>
										<p id= <?php echo $list['tid'];?>> <?php echo $list['body']."</p>";
										if(isset($list['link'])){?>
										<p>
										<iframe src="<?php echo $list['link']; ?>"></iframe>
										<a href="<?php echo $list['link']; ?>"  class="btn btn-default" target=_new><em><strong>Download notes</strong></em></a></p>
										<!--<a class="btn btn-default like" href="likeTweet.php?tid=<?php echo $list['tid'];?>"></a><?php/*singleTweet.php?tid=<?php echo $list['tid'];?>&action=l" ></a>*/?>-->
										<?php }

										$_SESSION['tid']=$list['tid'];
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
										}/*echo $_SESSION['tid'];*/ ?>

										<a href="#" class="likesnumber">
											<?php echo $list['likes']."			";?>
											
										</a>
										<?php
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
										}?><a href="#" class="retweetnumber">
											<?php echo $list['retweet'];?>
											
										</a> 
										
										

										<!--<a class="btn  retweet" href="likeTweet.php?tid=<?php echo $list['tid'];?>">
											<span class="glyphicon glyphicon-retweet"></span>
										</a>-->
										
									</div><!--closing div for media body-->
								</div><!--closing div for media-->
							</div><!--closing div of well-->
				 			<?php
				 		}
					}
					else{?>
					<span class="h3"><strong>Start tweeting and following people.</strong></span>
					<span class=" visible-xs visible-sm"><i>You are on small screen, to find your peers click on the navigation bar on top</i> </span>
<?php
                		
					}	?>
				
				</div><!--closing div of col-xs-12-->
			</div><!--closing div of inner row-->
		</div><!--closing div of main column col-md-6-->
		<div class="col-md-3 hidden-xs hidden-sm"><!--third column of large lg page-->
			<br>
			<div class="well">
				<span class="h4 strong"><strong>Who to follow?</strong></span><a href="showAllUsers.php"> view all</a><br><br>
				<?php
				$users = suggestNewUsers($_SESSION['uid']);
				if (count($users)) {	?>
			
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
                				<dd><strong><font color="#9d9d9d"><?php echo ($value['totalFollowers']-1)." followers"?></font></strong></dd>
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
				}	?>
			</div> <!--close of who to follow well -->
					
		</div>
	</div>
		</div><!--end row-->
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		
	</div>
				
				
			<!--<div class="col-md-12">
				<h4>trending hashtags</h4>
				<?php $hash  = showMostUsedHashtagsInADay();
				if(count($hash)){
					foreach ($hash as $key => $value) {
					# code...
					echo $value['hash'];
					}
				}
				
				 ?>
			</div>-->
		</div>
</div>

</body>
</html>
