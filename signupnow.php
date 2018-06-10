<?php 
session_start();
if(!isset($_SESSION['signupnow'])){
    $_SESSION['signupnow'] = 1;//remember to unset before going to another page
    include 'verify1.php';//avoid infinite loop of cycles between verify1 and this page
}
?>
<HTML>
<HEAD>
	<title>Rnsitwitter</title>
	<style type="text/css">
		h1{
			text-align: center;
			background: #1DA1F2;
			color: white;
		}
		
	</style>
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

	 <div class="row"></div>
	 <div class="well col-sm-offset-2 col-sm-9" >
		 <div class="col-sm-offset-1 col-sm-8">
		 	<form method ="post" action="signup.php"<?php unset($_SESSION['index']); ?> autocomplete="on">
				<?php //$_SESSION["action"]="signup";//check in verify.php if its signup/login?>
				<h3><strong>Join RNSIT Witters today.</strong></h3>
				<div class="form-group">
					<input class="form-control" placeholder="Enter Full Name" type="textbox" name = "name" required="true">
				</div>
				<div class="form-group">
					<input class="form-control" placeholder="Enter Username" type="textbox" name="username" required="true">
				</div>

				<div class="form-group">
					<input class="form-control" placeholder="Enter Phone Number" type="text" name = "phone" onkeypress="phoneno()" pattern="[1-9]{1}[0-9]{9}" required="true" maxlength="10">
				</div>
				<script>        
           function phoneno(){          
            $('#phone').keypress(function(e) {
                var a = [];
                var k = e.which;

                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k)>=0))
                    e.preventDefault();
            });
        }
       </script>
				<div class="form-group">
					<input class="form-control" placeholder="Enter Password" type="password" name = "password" required="true" autocomplete="off">
				</div>
				<div class="form-group">
					<input class="form-control" placeholder="Reenter the Password" type="password" name = "retypedpassword" required="true" autocomplete="off">
				</div>
				<div class="form-group">
					<input class="form-control" type="Date" name = "dob" required="true">
				</div>
		
				<select class="form-control"  placeholder="Select Department" name="country">
					<option value="ise">ISE</option>
					<option value="cse">CSE</option>
					<option value="ece">ECE</option>
					<option value="me">ME</option>
					<option value="eee">EEE</option>
					<option value="eie">EIE</option>
					<option value="civ">CIV</option>
				</select>
				<br>
				<div class="form-group">
					<input class="btn form-control" type="Submit" name="Signup" value="Signup">
				</div>
				<br>	
				<strong>Have an account? <a href="index.php"<?php unset($_SESSION['index']); ?>>Log in »</a></strong>
				<br>
				<?php
				if (isset($_SESSION['message'])):
    			echo "<font color='red'><strong>". $_SESSION['message']."</strong></font>";
    			unset($_SESSION['message']);
    			endif;
				?>	
			</form>
		</div>
	</div>
</div>
</body>
</HTML>