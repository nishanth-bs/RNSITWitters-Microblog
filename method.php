<?php
function getConnectionToDb(){
	$connection = mysqli_connect("localhost","root","");
	mysqli_select_db($connection,"nishanth3");
	return $connection;
}

function showLogoutButton(){
	echo "<form action= \" logout.php\">
		<input type=\"submit\" name=\"logout\" value=\"Logout\" >
</form>";
}

function showTweetBox(){
	echo "<form method=\"post\" action=\"tweet.php\">
	<h3> Type tweet 140 characters limit</h3>
	<textarea name='body' rows='5' cols='50'  maxlength='140' required></textarea>
	<p><input type='submit' value='Tweet' /></p>
</form>";
}

function show_posts($uid){
    $posts = array();
 
    //$sql = "select tweet, time from tweets where uid = '$uid' order by time desc";//natural join user_detail
$sql=<<<EO
select t.tid as tid,t.uid,u.name,u.user_name,t.link,t.tweet,t.time,t.likes,t.retweet from tweets t, user_detail u where t.uid in(
select MAIN_UID from followers where f_uid= $uid  ) and u.uid=t.uid ORDER BY t.`TIME` DESC
EO;
$sql2 = <<<E
select 
E;
    $connection = getConnectionToDb();
    $result = mysqli_query($connection,$sql);
 
    while($data = mysqli_fetch_object($result)){
        $posts[] = array(   'time' => $data->time, 
                            'uid' => $data->uid, 
                            'tid'=>$data->tid,
                            'name' =>$data->name,
                            'link'=>$data->link,
                            'uname'=>$data->user_name,
                            'body' => $data->tweet,
                            'likes' =>$data->likes,
                            'retweet'=>$data->retweet
                    );
    }
    return $posts;
 
}
function showCurUserT($uid){
    $posts = array();
 
    //$sql = "select tweet, time from tweets where uid = '$uid' order by time desc";//natural join user_detail
$sql=<<<EO
select t.tid as tid,t.uid,u.name,u.user_name,t.link,t.tweet,t.time,t.likes,t.retweet from tweets t, user_detail u where t.uid=$uid and u.uid=t.uid ORDER BY t.`TIME` DESC
EO;
$sql2 = <<<E
select 
E;
    $connection = getConnectionToDb();
    $result = mysqli_query($connection,$sql);
 
    while($data = mysqli_fetch_object($result)){
        $posts[] = array(   'time' => $data->time, 
                            'uid' => $data->uid, 
                            'tid'=>$data->tid,
                            'link'=>$data->link,
                            'name' =>$data->name,
                            'uname'=>$data->user_name,
                            'body' => $data->tweet,
                            'likes' =>$data->likes,
                            'retweet'=>$data->retweet
                    );
    }
    return $posts;
 
}
function getCurTweet($tid){
    $singleTweet = array();
    $sql =<<<Display
SELECT t.UID,u.NAME as name,u.USER_NAME as user_name,t.TWEET as tweet,t.TIME as time,t.LIKES as likes FROM tweets t JOIN user_detail u on u.UID=t.UID where t.tid= $tid
Display;
////SELECT t.UID,t.TWEET,t.TIME,t.LIKES FROM tweets t where tid=$tid;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$sql);
    while($data =mysqli_fetch_object($res)){
        $singleTweet[] = array(     'time'=>$data->time,
                                    'name'=>$data->name,
                                    'uname'=>$data->user_name,
                                    'tweet'=>$data->tweet,
                                    'time'=>$data->time,
                                    'likes'=>$data->likes);
    }
    return $singleTweet;
}


function likeOrUnlikeTheTweet($tid,$uid){
    $sql1=<<<INSER
    INSERT INTO likes(tid, uid) VALUES ($tid,$uid);
INSER;
    $sql2=<<<Delet
    delete from likes where tid=$tid and uid = $uid;
Delet;
    $sql3=<<<Selec
    select * from likes where tid=$tid and uid=$uid;
Selec;
    $connection = getConnectionToDb();
    $res= mysqli_query($connection,$sql3);
    if(mysqli_num_rows($res) == 1){
        mysqli_query($connection,$sql2);
        return true;?>
        <span class="glyphicon glyphicon-heart-empty"></span>
        <span class="glyphicon glyphicon-heart"></span>
<?php    }
    else{
        mysqli_query($connection,$sql1);
        return false;
    }

}

function retweet($tid,$uid){
    //check if the person has already retweeted the post
    $sql=<<<selec
select * from retweet where tid = $tid and uid = $uid;
selec;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$sql);
    if(mysqli_num_rows($res)==0){
        //insert tid and uid that is RETWEETED
        $sql1 = <<<inser
insert into retweet values($tid,$uid);
inser;
        mysqli_query($connection,$sql1);
        return true;
    }
    else{
        return false;
    }
}
function checkIfLikedOrNot($tid,$uid){
    $sql=<<<selec
select * from likes where tid = $tid and uid = $uid
selec;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$sql);
    if(mysqli_num_rows($res)==1){
        return true;
    }
    else{
        return false;
    }
}
function getAllTidWhichTheCurrentUserHasLiked($uid){
    $tidArr = array();
    $sql = <<<h
select tid from likes where uid = $uid
h;
    $connection = getConnectionToDb();
    $sel = mysqli_query($connection,$sql);
    while ($data = mysqli_fetch_object($sel)) {
        # code...
        //echo "$data->tid";
        $tidArr[] = array($data->tid);
    }
    return $tidArr;
}
function getAllTweetsWhichTheCurrentUserHasLiked($uid){
    $tidArr = array();
    $sql = <<<h
    select t.tid as tid,t.uid,u.name,u.user_name,t.tweet,t.time,t.likes,t.retweet from tweets t, user_detail u where u.uid=t.uid and t.TID in(
select tid from likes where uid = $uid)
h;
    $connection = getConnectionToDb();
    $result = mysqli_query($connection,$sql);
 
    while($data = mysqli_fetch_object($result)){
        $tidArr[] = array(   'time' => $data->time, 
                            'uid' => $data->uid, 
                            'tid'=>$data->tid,
                            'name' =>$data->name,
                            'uname'=>$data->user_name,
                            'body' => $data->tweet,
                            'likes' =>$data->likes,
                            'retweet'=>$data->retweet
                    );
    }
    return $tidArr;
}
function getAllTidWhichTheCurrentUserHasRetweeted($uid){
    $tidArr = array();
    $sql = <<<h
select tid from retweet where uid = $uid
h;
    $connection = getConnectionToDb();
    $sel = mysqli_query($connection,$sql);
    while ($data = mysqli_fetch_object($sel)) {
        # code...
        //echo "$data->tid";
        $tidArr[] = array($data->tid);
    }
    return $tidArr;
}

function getAllTweetsWhichTheCurrentUserHasRetweeted($uid){
    $tidArr = array();
    $sql = <<<h

    select t.tid as tid,t.uid,u.name,u.user_name,t.tweet,t.time,t.likes,t.retweet from tweets t, user_detail u where u.uid=t.uid and t.TID in(
select tid from retweet where uid = $uid)
h;
    $connection = getConnectionToDb();
    $result = mysqli_query($connection,$sql);
    //if(count($result)){
    while($data = mysqli_fetch_object($result)){
        $tidArr[] = array(   'time' => $data->time, 
                            'uid' => $data->uid, 
                            'tid'=>$data->tid,
                            'name' =>$data->name,
                            'uname'=>$data->user_name,
                            'body' => $data->tweet,
                            'likes' =>$data->likes,
                            'retweet'=>$data->retweet
                    );
    }
    return $tidArr;

}

function checkIfRetweetedOrNot($tid,$uid){
    $sql=<<<selec
select * from retweet where tid = $tid and uid = $uid
selec;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$sql);
    if(mysqli_num_rows($res)==1){
        return true;
    }
    else{
        return false;
    }
}
function getMostUsedHashtags(){
    $hashtags = array();
    $sql=<<<php
    SELECT hashtag, COUNT(hashtag) as C FROM hashtags GROUP BY hashtag ORDER BY C desc limit 10
php;
$sql1 = <<<ii
select hashtag,tid from hashtags
ii;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$sql);
    while ($data = mysqli_fetch_object($res)) {
        $hashtags[] = array('hash'=> $data->hashtag,
                            'coun'=>$data->C);
        //echo $data->hashtag;
       // echo $data->C;
    }
    return $hashtags;

}
function getRelevantHashtags($tweetBody){
    $relevantHashtags = array();
    $sql = <<<y
select t.tid as tid,t.uid,u.name,u.user_name,t.tweet,t.time,t.likes,t.retweet from tweets t, user_detail u where t.tid IN(SELECT h.TID FROM hashtags h WHERE h.hashtag = '$tweetBody') and t.uid=u.uid;
y;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$sql);
    while ($data = mysqli_fetch_object($res)) {
        $relevantHashtags[] =array('time' => $data->time, 
                            'uid' => $data->uid, 
                            'tid'=>$data->tid,
                            'name' =>$data->name,
                            'uname'=>$data->user_name,
                            'body' => $data->tweet,
                            'likes' =>$data->likes,
                            'retweet'=>$data->retweet);
    }
    return $relevantHashtags;
}

function show_cur_user_posts($uid){
    $posts = array();
 
    $sql = "select tweet, time from tweets where uid = '$uid' order by time desc";//natural join user_detail
/*$sql=<<<EO
select tweet,time from tweets where uid in(
select MAIN_UID from followers where f_uid= '$uid')             DECLARE @likes INT
SELECT @likes= likes from tweets
@likes= @likes +1
UPDATE TABLE tweets t WHERE  t.LIKES=@likes
EO;*/
    $connection = getConnectionToDb();
    $result = mysqli_query($connection,$sql);
 
    while($data = mysqli_fetch_object($result)){
        $posts[] = array(   'time' => $data->time, 
                            'uid' => $uid, 
                            'body' => $data->tweet
                    );
    }
    return $posts;
 
}

function showAllUsers(){
	$users = array();

	$sql1 = "Select distinct main_uid from followers where f_uid = \"".$_SESSION['uid']."\"";
	$sql = "select uid, user_name from user_detail order by user_name; ";
	$finalSql = <<<I
	$sql minus $sql1
I;
	$connection = getConnectionToDb();
	$result = mysqli_query($connection,$sql);

	while($data = mysqli_fetch_object($result)){
		$users[] = array('uid'=>$data->uid,
							'user_name'=>$data->user_name);
	}
	return $users;
}
function suggestAllUser($uid){
    $users = array();
    $storedProcedure1=<<<a
    SET @p0='$uid'; 
a;
    $storedProcedure2 =<<<b
    CALL `suggestAllUsers`(@p0);
b;
    $connection = getConnectionToDb();
    mysqli_query($connection,$storedProcedure1);
    $result = mysqli_query($connection,$storedProcedure2);
    while($data = mysqli_fetch_object($result)){
        $users[]= array('ud'=>$data->uid,
                        'name'=>$data->name,
                            'uname'=>$data->username,
                            'totalFollowers'=>$data->totalFollowers);
    }
    return $users;

}
function suggestNewUsers($uid){
    $users = array();
    //$uid = $_SESSION['uid'];
    $sql = <<<III
SELECT u.UID as uid,u.name as name,u.USER_NAME as username FROM user_detail u WHERE u.UID NOT IN ( SELECT f.MAIN_UID FROM followers f WHERE f.F_UID= $uid)
III;
$GETNUMBEROFFOLLOWERS=<<<S
SELECT f.F_UID,COUNT(f.F_UID) FROM followers f WHERE f.MAIN_UID=1 GROUP by f.MAIN_UID
S;
// just selects the users who the current user isnt following
//SELECT DISTINCT(f.MAIN_UID),COUNT(f.F_UID) FROM followers f GROUP BY f.F_UID ORDER BY COUNT(f.F_UID) DESC 
    $sql2 = <<<IMP
    SELECT f.MAIN_UID,COUNT(f.MAIN_UID) as c FROM followers f GROUP BY f.MAIN_UID ORDER BY c desc limit 5
IMP;
    $storedProcedure = <<<wow
    SET @p0='$uid'; 
wow;
$ss = <<<i
CALL `suggestFollowers`(@p0);
i;
    $connection = getConnectionToDb();
    $res = mysqli_query($connection,$storedProcedure);
    $result = mysqli_query($connection,$ss);


    while($data = mysqli_fetch_object($result)){
        $users[]= array('ud'=>$data->uid,
                        'name'=>$data->name,
                            'uname'=>$data->username,
                            'totalFollowers'=>$data->totalFollowers);
    }
    return $users;
} 
function showFollowing($user_id){
	/*$users=array();
	$sql = "select main_uid from followers where f_uid = ".$user_id;
	$connection = getConnectionToDb();

	$res = mysqli_query($connection,$sql);
	while($data = mysqli_fetch_object($res)){
		array_push($users, $data->main_uid);
	}	
	try{if (count($users)){
            $uid_string = implode(',', $users);
 
    }
    $following = array();
    $sql2 = "select uid, user_name from user_detail where uid in (".$uid_string.") order by user_name";
    echo "$uid_string";*/
    $sql2=<<<a

select u.UID as uid,u.name as name,u.USER_NAME as username  from user_detail u where uid in (select main_uid from followers where f_uid = $user_id and main_uid != $user_id) order by user_name
a;
$connection=getConnectionToDb();
$following=array();
    $res = mysqli_query($connection, $sql2);
    while($data = mysqli_fetch_object($res)){
    	$following[]= array('ud'=>$data->uid,
                        'name'=>$data->name,
                            'uname'=>$data->username);
    }//}
    
    //catch(Exception $e){}
	return $following;
}

function showFollowers($user_id){
    /*$users=array();
    $sql = "select f_uid from followers where main_uid = ".$user_id;
    $connection = getConnectionToDb();

    $res = mysqli_query($connection,$sql);
    while($data = mysqli_fetch_object($res)){
        array_push($users, $data->main_uid);
    }   
    try{if (count($users)){
            $uid_string = implode(',', $users);
 
    }
    $following = array();
    $sql2 = "select u.UID as uid,u.name as name,u.USER_NAME as username  from user_detail u where uid in (".$uid_string.") order by user_name";
    echo "$uid_string";

*/$sql2=<<<a
    select u.UID as uid,u.name as name,u.USER_NAME as username  from user_detail u where uid in (select f_uid from followers where main_uid = $user_id and f_uid != $user_id) order by user_name
a;
$following=array();
$connection=getConnectionToDb();
    $res = mysqli_query($connection, $sql2);
    while($data = mysqli_fetch_object($res)){
        $following[]= array('ud'=>$data->uid,
                        'name'=>$data->name,
                            'uname'=>$data->username);
    }//    }
    
    //catch(Exception $e){}
    return $following;
}
function showNavigationBar($back){?>
    <div class="row">
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="navbar-header">
            <?php if( $back !=0):?>
    <a href="login1.php" class="navbar-brand"><span class="glyphicon glyphicon-arrow-left restrictGlyphicon"></span></a>
<?php endif; ?>
            <a class="navbar-brand"><strong>RNSIT Witters</strong></a>
            <?php if($back !=2):?>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#square">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        <?php endif; ?>
        </div> <!--navbar-header-->
        <!--<form class="navbar-form navbar-left" action="" role="search">
            <div class="form-group">
            <input type="text" class="form-control" placeholder="Search user">
            </div>
            <button type="submit" class="btn btn-default btn-sm">Search</button>
        </form>
    -->
        <div class="navbar-collapse collapse" id="square">
            <ul class="nav navbar-nav navbar-right">
                <!--<li><a href = "userprofile.php?user=<?php echo $_SESSION["uname"]; ?>"><strong><em><?php echo $_SESSION["uname"]; ?></em></strong></a></li>-->
                <li><a href="login1.php"><span class="glyphicon glyphicon-home restrictGlyphicon"></span></a></li>
                <li class="dropdown">
                    

                        <a data-toggle="dropdown" class="btn dropdown-toggle" id="user-dropdown-toggle">
                            <span>
                                <img class = "makeItRound restrictImageSize" src="default_profile_pic.png">
                            </span>
                            <span>
                                <?php echo $_SESSION['uname'];?>
                            </span>
                            <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended">
                        <li class="dropdown-header"><strong><b><h4><?php echo $_SESSION['name']."<br/><i><h5>".$_SESSION['uname'];?></h5></i> </h4></b></strong></li>
                        <li class="divider visible-xs visible-sm"></li>
                        <li class="visible-xs visible-sm"><a href="hashtagForxssm.php">Hashtags</a></li>
                        <li class="visible-xs visible-sm"><a href="suggestUsersForxssm.php">Suggested users</a></li>
                        <li class="divider"></li>
                        <li><a href="userprofile.php?user=<?php echo $_SESSION['uname']; ?>">My Profile</a></li>
                        <!--<li><a href="#">Settings<span class="badge">Upcoming</span></a></li>-->
                        <li><a href="logout.php">Logout</a></li>
                        <li class="divider"></li>
                        <li><a href="dev.php">About the developer</a></li>
                    </ul>
                    
                </li>
            </ul>
        </div><!-- navbar-collapse-->
    </nav>
</div>

    <?php
}

?>

