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

<?php
showNavigationBar(1);
$curHash = "#".$_GET["hash"];
//$posts = show_posts($_SESSION["uid"]);
//$tidArr = getAllTidWhichTheCurrentUserHasLiked($_SESSION['uid']);
//$rtidArr = getAllTidWhichTheCurrentUserHasRetweeted($_SESSION['uid']);?>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12 col-sm-12">
        <div class="col-xs-12">
                    
                    <?php
                    $relevantHashtags = getRelevantHashtags($curHash);
                    //echo "$curHash";
                    
                    $tidArr = getAllTidWhichTheCurrentUserHasLiked($_SESSION['uid']);
                    $rtidArr = getAllTidWhichTheCurrentUserHasRetweeted($_SESSION['uid']);
                        /*if(count($tidArr)){
                            foreach ($tidArr as $key => $value) {
                                # code...
                                echo $value['tid']."<br/>";
                                var_dump($value);
                                if(in_array(1, $value)){
                                                    echo "dddddddddddddddddddddddd";

                                                }
                                
                            }
                        }*/
                        
                    if (count($relevantHashtags)) {    ?>
                <br>
                                <span class="h2"><strong><?php echo $curHash;?></strong> </span>
                
                        <?php
                        $_SESSION['previous_location']='hashtags.php?hash='.$_GET['hash'];

                        foreach ($relevantHashtags as $key => $list) {
                            # code...
                            /*echo "<tr valign='top'>\n";
                            echo "<td>" . $list['uid'] . "</td>\n";
                            echo "<td>" . $list['body'] . "<br/>\n";
                            echo "<small>" . $list['time'] . "</small></td>\n";
                            echo "</tr>";
                            echo <<<I
                            </table>

I;*/                //var_dump($list);  ?>              
                                
                            <div class="well">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img src="default_profile_pic.png" class="media-object makeItRound">
                                        </a>
                                    </div>

                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="userprofile.php?user=<?php echo $list['uname']; ?>"><?php echo $list['name']; ?></a> </h4>
                                        <small><i> @<?php echo "<strong>".$list['uname']."</strong><br>";$time=strtotime($list['time']); 
                                        echo date('d-m-y',$time); echo $list['time'];  ?></i></small>
                                        <p id= <?php echo $list['tid'];?>> <?php echo $list['body']; ?></p>
                                        <!--<a class="btn btn-default like" href="likeTweet.php?tid=<?php echo $list['tid'];?>"></a><?php/*singleTweet.php?tid=<?php echo $list['tid'];?>&action=l" ></a>*/?>-->
                                        <?php 

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
                                            <?php echo $list['likes']."         ";?>
                                            
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
                    else{
                        echo '<h4>no tweets with the specified hastag</h4> ';
                    }   ?>
                
                </div><!--closing div of col-xs-12-->
    </div>
    <div class="col-md-3 hidden-xs hidden-sm"><!--third column of large lg page-->
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
                
</div>

?>