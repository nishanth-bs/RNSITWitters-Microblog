<?php
require_once 'method.php';
$connection=getConnectionToDb();
if($_GET['type'] == 'country'){
	$result = mysqli_query("SELECT user_name FROM user_detail where name LIKE '".strtoupper($_GET['name_startsWith'])."%'");	
	$data = array();
	while ($row = mysqli_fetch_array($result)) {
		array_push($data, $row['name']);	
	}	
	echo json_encode($data);
}

?>