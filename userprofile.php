<?php
session_start();
include_once("method.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <style type="text/css">
    .margind{
      margin-top: 80px;
    }
  </style>
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

  <!--<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/twitterbootstrap/js/bootstrap-tab.js"></script>-->
</head>
<body>
<?php
if(isset($_GET["user"])){
  $user = $_GET["user"];

  $connection = getConnectionToDb();
  $val = mysqli_query($connection,"Select uid from user_detail where user_name = '".$user."';");  //get the user id for the corresponding username
  while($data= mysqli_fetch_object($val)){
    $uid = $data->uid;            //getting the string from resultset object
    //echo "$uid";
    
  }
  $posts = showCurUserT($uid);
  $tidArr = getAllTweetsWhichTheCurrentUserHasLiked($uid);
  $selftidArr = getAllTweetsWhichTheCurrentUserHasLiked($_SESSION['uid']);
  $rtidArr = getAllTweetsWhichTheCurrentUserHasRetweeted($uid);
  $selfrtidArr = getAllTweetsWhichTheCurrentUserHasRetweeted($_SESSION['uid']);
  $noFollowing = showFollowing($uid);
  $noFollowers = showFollowers($uid);
  
?>
<div class="container">
<?php showNavigationBar(1);
$_SESSION['previous_loc']="userprofile.php?user=".$user;?>

<div class="row margind">
<div class="col-md-2">
  <div class="row">
    <div class="well">
      <?php

  echo $user;}
  //echo ($val["uid"]);
?><form method="post" action ="followorblock.php">
  <?php

  $sql2 = "Select MAIN_UID from followers where MAIN_UID=\"".$uid."\" and F_UID=\"".$_SESSION["uid"]."\" and BLOCK_FLAG=true";
  //prepare sql statement , pass it inside the below mysqli_query function, 
  $res2 = mysqli_query($connection,$sql2);
  //this executes the query and returns the  resultset
  $following = mysqli_num_rows($res2);//cthis function checks the number of rows in the returned resultset object
  switch ($following) {   //my code logic DONT worry
    case '0':
      $temp = "FOLLOW";
      break;
    default:
      $temp = "UNFOLLOW";
      break;
  }
  echo "<input class='btn btn-default center-block' type=\"submit\" name=\"act\" value=".$temp.">";
  
  ?>

  <!--<input class='' type="submit" name="act" value= "Block">-->   <!-- This gives a submit button, on clicking this it 
  goes to file in the action field mentioned in the form action above-->
  
<?php echo "<input type=\"hidden\" name= \"fname\" value= \"". $user."\">";
echo "<input type = \"hidden\" name= \"fid\" value =\"".$uid."\">";

  
?>
</form>

    </div>
  </div>
</div>
<div class="col-md-8">
  <ul class="nav nav-tabs tabs">
    <li class="active"><a data-toggle="tab" href="#home">Tweets <span class="badge"><?php echo count($posts);?></span></a></li>
    <li><a data-toggle="tab" href="#menu4">Retweets <span class="badge"><?php echo count($rtidArr);?></span></a></li>
    <li><a data-toggle="tab" href="#menu1">Followers <span class="badge"><?php echo count($noFollowers);?></span></a></li>
    <li><a data-toggle="tab" href="#menu2">Following <span class="badge"><?php echo count($noFollowing);?></span></a></li>
    <li><a data-toggle="tab" href="#menu3">Likes <span class="badge"><?php echo count($tidArr);?></span></a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <?php //if($following){
              if (count($posts)){?>
                
              
                    <?php   $_SESSION['previous_location']='userprofile.php?user='.$user."#home";
                      foreach ($posts as $key => $list) { ?>        
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
                        <small><i> @<?php echo "<strong>".$list['uname']."</strong><br>"; echo $list['time'];  ?></i></small>
                        <p id= <?php echo $list['tid'];?>> <?php echo $list['body']."</p>"; 
                        if(isset($list['link'])){?>
                       <p> <iframe src="<?php echo $list['link']; ?>"></iframe>
                    <a href="<?php echo $list['link']; ?>"  class="btn btn-default" target=_new><em><strong>Download notes</strong></em></a></p>
                    
                        <?php } $_SESSION['tid']=$list['tid'];
                        $flag = false;
                        foreach ($selftidArr as $key => $value) {
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
                        foreach ($selfrtidArr as $key => $value) {
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
    <div id="menu1" class="tab-pane fade">
      <?php if (count($noFollowers)) {    
        
        foreach ($noFollowers as $key => $value) {?>
            <div class="well col-lg-3 col-md-4 col-sm-6 ">
                    
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img src="default_profile_pic.png" class="media-object makeItRound">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="userprofile.php?user=<?php echo $value['uname']; ?>"><?php echo $value['name']; ?></a> </h4>
                            <small><i>@<?php echo $value['uname']; ?></i></small><br><br>
                            <?php $_SESSION['previous_location']= "userprofile.php?user=".$user."#menu1";  
                            /*if(in_array($value['ud'], $noFollowing)){
                                echo "asdf";
                            }
                            else{
                            ?>
                            <form method="post" action="followorblock.php">
                                <input type="hidden" name="fid" value="<?php echo $value['ud']?>">
                                <input type="hidden" name="fname" value="<?php echo $value['uname'];?>">
                                <input type = "submit" name="act" value="FOLLOW" class="btn btn-info "></input>

                                <!--<input type="submit" name="act" value="FOLLOW" class="btn btn-default">-->
                            </form><?php echo $_SESSION['uid']. $value['ud']; var_dump($noFollowing);}*/?>
                        </div>

                </div>
            </div>
    <?php }} ?></div>
    <div id="menu2" class="tab-pane fade">
      <?php if (count($noFollowing)) {    
        
        foreach ($noFollowing as $key => $value) {?>
            <div class="well col-lg-3 col-md-4 col-sm-6 ">
                    
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img src="default_profile_pic.png" class="media-object makeItRound">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="userprofile.php?user=<?php echo $value['uname']; ?>"><?php echo $value['name']; ?></a> </h4>
                            <small><i>@<?php echo $value['uname']; ?></i></small><br><br>
                            <?php $_SESSION['previous_location']= "userprofile.php".$user."#menu2"; /*?>
                            <form method="post" action="followorblock.php">
                                <input type="hidden" name="fid" value="<?php echo $value['ud']?>">
                                <input type="hidden" name="fname" value="<?php echo $value['uname'];?>">
                                <input type = "submit" name="act" value="FOLLOW" class="btn btn-info "></input>
                                <!--<input type="submit" name="act" value="FOLLOW" class="btn btn-default">-->
                            </form><?php */ ?>
                        </div>

                </div>
            </div>
    <?php }} ?></div>
    
    <div id="menu3" class="tab-pane fade">
      <?php //if($following){
              if (count($tidArr)){?>
                
              
                    <?php   $_SESSION['previous_location']='userprofile.php?user='.$user."#menu3";
                      foreach ($tidArr as $key => $list) { ?>        
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
                        <!--<a class="btn btn-default like" href="likeTweet.php?tid=<?php echo $list['tid'];?>"></a><?php/*singleTweet.php?tid=<?php echo   $list['tid'];?>&action=l" ></a>*/?>-->
                        <?php $_SESSION['tid']=$list['tid'];
                        $flag = false;
                        foreach ($selftidArr as $key => $value) {
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
                        foreach ($selfrtidArr as $key => $value) {
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
          //}
          //else{
           // echo "<strong><h2>you arent following the user</h2></strong>";
          //}?>
          <div id="menu4" class="tab-pane fade">
      
      <?php //if($following){
              if (count($rtidArr)){?>
                
              
                    <?php   $_SESSION['previous_location']='userprofile.php?user='.$user."#menu4";
                      foreach ($rtidArr as $key => $list) { ?>        
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
                        <!--<a class="btn btn-default like" href="likeTweet.php?tid=<?php echo $list['tid'];?>"></a><?php/*singleTweet.php?tid=<?php echo   $list['tid'];?>&action=l" ></a>*/?>-->
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
          //}
          //else{
           // echo "<strong><h2>you arent following the user</h2></strong>";
          //}?>
    </div>
        </div></div>

      </div>
    </div>
  <?php ?>
    </div>
  </div>
</div>
</body>
</html>
