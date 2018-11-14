<?php
session_start();/*
if(!isset($_SESSION['index'])){
    $_SESSION['index'] = 1;//remember to unset before going to another page
    include_once ('verify1.php');//avoid infinite loop of cycles between verify1 and index
}*/
$_SESSION['logged_in']=false;
?>
<HTML>
<HEAD>
	<title>Rnsit Witter|Login Page</title>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="customizedStyleSheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>


<body>
	<header class="header">
		
	</header>
<div class="container">
	<nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand"><strong>RNSIT Witters</strong></a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#square">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>


	</nav>
	 <div class="well col-sm-offset-2 col-sm-9" >
		 <div class="col-sm-offset-1 col-sm-8">
		 	<form  method = "post" action = "login1.php">
				<h3 class="no-wrap"><strong>Log in to RNSIT Witters</strong></h3>
				<div class="form-group">
					<input class="form-control" placeholder="Username" type="textbox" name = "name" required="true">
				</div>
				<div class="form-group">
					<input class="form-control" placeholder="Password" type="password" name = "password" required="true">
				</div>
				<input class="btn " type="Submit" value = "Login">
				<?php
				if (isset($_SESSION['invalidUorP'])):
		    		echo "<b><font color=\"red\">". $_SESSION['invalidUorP']."</font></b>";
		    		unset($_SESSION['invalidUorP']);
		    	endif;
		    	if (isset($_SESSION['successCreation'])):
		    		echo "<b><font color=\"green\">". $_SESSION['successCreation']."</font></b>";
		    		unset($_SESSION['successCreation']);
		    	endif;
				?>
			</form>

			<br><strong>New to RNSIT Witters? <a href="signupnow.php"<?php /*unset($_SESSION['index']);*/ ?>>Signup now »</a></strong><br>
	 	</div>
	 </div>
</div>
</body>
</HTML>
