<?php
session_start();
?>

<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 
<head>
<title> Radio Station</title>
<link rel="stylesheet" type="text/css" href=" ../cssfolder/style.css">
</head>
	<body>
	<div class= "container">
	<div class="page-header">
	<h1>Hello, <?php if (isset($_SESSION['login_user']))
      echo $_SESSION['login_user'];?>	
	</h1>	
	</div>
	
	<p><big>Tell us about your preference!</big></p>

		<form method="post" action="addpreference.php">	
		<div class = "row">	
			<div class="form-group" >
				<input name = "preference" type="text" class="form-control" >
				
			</div>
			<button class="btn btn-default" name="submit" type="submit">Add</button>
		</div>	
		
	  	</form>	
	  		<?php include 'showpreference.php';?>

	<p><big>Suggested Radio Station:</big></p>

	  		<?php include 'songsearchwithpreference.php';?>


	</div>
	</body>
</html>