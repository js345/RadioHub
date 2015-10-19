<?php

include('login_process.php'); // Includes Login Script
if(isset($_SESSION['login_user'])){
header("location: index.html");

}



?>
<!DOCTYPE html>
<html>
<head>
<title>Login Form in PHP with Session</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="main" class="container">
		<br><br>
		<div class="page-header">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h1>Please login here</h1>
			</div>
		</div>
		</div>
		
			<form action="login_process.php" method="post">
				<div class="row"><div class="col-md-6 col-md-offset-3">
					<div class="form-group" ><label>UserName :</label>
				<input class="form-control" id="name" name="name" placehoder = "name" type="text">
				</div></div></div>
				<div class="row"><div class="col-md-6 col-md-offset-3"><div class="form-group" ><label>Password :</label>
				<input class="form-control" id="password" name = "password" placeholder="**********" type="password">
				</div></div></div>
				<div class="row">
					<div class="col-md-6 col-md-offset-3"><button class="btn btn-default" name="submit" type="submit">Login</button>
				</div></div>
			
			</form>
			<br>
		<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<a href="http://csproject.web.engr.illinois.edu"><big>Go back</big></a>
				</div>
		</div>
	</div>
</body>
</html>