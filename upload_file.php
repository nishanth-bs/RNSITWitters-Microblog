<?php
 
 $targetfolder = "testupload/";
 
 $targetfolder = $targetfolder . mt_rand(10,100).basename( $_FILES['file']['name']);
 $connection = getConnectionToDb();
 
 $ok=1;
 
$file_type=$_FILES['file']['type'];
 
if ($file_type=="application/pdf" || $file_type=="image/gif" || $file_type=="image/jpeg") {
 
 if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))
 
 {
 
 echo "The file ". basename( $_FILES['file']['name']). " is uploaded";

 $sql =<<<a
INSERT INTO `tweets`( UID, TWEET, IMAGE, LINK, TIME, LIKES, RETWEET) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])
a;
 }
 
 else {
 
 echo "Problem uploading file";
 
 }
 
}
 
else {
 
 echo "You may only upload PDFs, JPEGs or GIF files.<br>";
 
}
 
?>