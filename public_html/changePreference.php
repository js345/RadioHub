<?php
session_start();
?>

<html>
<head>
    <!-- Theme Made By www.w3schools.com - No Copyright -->
    <title>RadioHub</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <style>
        body {
            font: 20px Montserrat, sans-serif;
            line-height: 1.8;
            color: #f5f6f7;
        }
        p {font-size: 16px;}
        .margin {margin-bottom: 45px;}
        .bg-1 {
            background-color: #1abc9c; /* Green */
            color: #ffffff;
        }
        .bg-2 {
            background-color: #474e5d; /* Dark Blue */
            color: #ffffff;
        }
        .bg-3 {
            background-color: #ffffff; /* White */
            color: #555555;
        }
        .bg-4 {
            background-color: #2f2f2f; /* Black Gray */
            color: #fff;
        }
        .container-fluid {
            padding-top: 70px;
            padding-bottom: 70px;
        }
        .navbar {
            padding-top: 15px;
            padding-bottom: 15px;
            border: 0;
            border-radius: 0;
            margin-bottom: 0;
            font-size: 12px;
            letter-spacing: 5px;
        }
        .navbar-nav  li a:hover {
            color: #1abc9c !important;
        }
    </style>
</head>
<body>

<!-- Navbar -->
	<nav class="navbar navbar-default">
	    <div class="container">
	        <div class="navbar-header">
	            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a class="navbar-brand" href="profile.php">Me</a>
	        </div>
	        <div class="collapse navbar-collapse" id="myNavbar">
	            <ul class="nav navbar-nav navbar-right">
	                <li><a href="changePreference.php">Change Preference</a></li>
	                <li><a href="#">Search Songs</a></li>
	                <li><a href="logout.php">Logout</a></li>
	            </ul>
	        </div>
	    </div>
	</nav>
</body>


<div class="container-fluid bg-1 text-center">
    <h2 class="margin">Update your preference:</h2>
    <form method="post" action="addpreference.php">	
		<div class = "row">	
			<div class="form-group" >
				<input name = "preference" type="text" class="form-control" >
				
			</div>
			<button class="btn btn-default" name="submit" type="submit">Add</button>
		</div>	
		
	</form>
</div>


<div class="container-fluid bg-2 text-center">
    <!-- <h3 class="margin">Your Favorite Songs</h3><br> -->
    <div class="row">
        <div class="col-sm-4">
            <p>
            	<p><big>Song List:</big></p>
                    
	  			<?php include 'songsearchwithpreference.php';?>
            </p>

        </div>
        <div class="col-sm-4">
            <p>
                <?php
                    $like2 = showSongs(1);
                    echo $like2;
                ?>
            </p>
            <form method="post" action="removelikesong.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" value= <?php echo "'{$like2}'" ?> >
                    </div>
                    <button type="submit" class="btn btn-danger">Dislike</button>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <p>
                <?php
                    $like3 = showSongs(2);
                    echo $like3;
                ?>
            </p>
            <form method="post" action="removelikesong.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" value= <?php echo "'{$like3}'" ?> >
                    </div>
                    <button type="submit" class="btn btn-danger">Dislike</button>
                </div>
            </form>
            <!-- img src="birds3.jpg" class="img-responsive margin" style="width:100%" alt="Image" -->
        </div>
    </div>
</div>



</html>









