<?php
session_start();
/*
function allSongs(){
    $hostname = "engr-cpanel-mysql.engr.illinois.edu"; // usually is localhost
    $db_user = "csprojec_admin"; // change to your database password
    $db_password = "admin"; // change to your database password
    $database = "csprojec_radiohub"; // provide your database name
    $db_table = "User"; // your database table name
    $conn = new mysqli($hostname, $db_user, $db_password, $database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_SESSION['login_user'])) {
        $temp = $_SESSION['login_user'];
    }

    // $sql = "SELECT RName FROM Likes WHERE Username= '$temp'";
    $sql = "SELECT Song.SName FROM Song, User WHERE Username= '$temp' AND User.Preference = Song.Genre";
    $result = $conn->query($sql);
    $arrayofrows = array();
    $count = 0;
    while($row = mysqli_fetch_array($result))
    {
        $arrayofrows[$count] = $row;
        $count++;
    }

    
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo $row['RName'];
            //echo "<br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    return $arrayofrows;
}
*/



function recommendSongs($num) {
    $hostname = "engr-cpanel-mysql.engr.illinois.edu"; // usually is localhost
    $db_user = "csprojec_admin"; // change to your database password
    $db_password = "admin"; // change to your database password
    $database = "csprojec_radiohub"; // provide your database name
    $db_table = "Song"; // your database table name
    $conn = new mysqli($hostname, $db_user, $db_password, $database);


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_SESSION['login_user'])) {
        $temp = $_SESSION['login_user'];
    }

    $sql = "SELECT DISTINCT Song.SName FROM Song JOIN Likes on Song.SName = Likes.Rname JOIN User on User.Preference = Song.Genre WHERE Likes.Username <>'$temp'";

    $result = $conn->query($sql);
    $arrayofrows = array();
    $count = 0;
    while($row = mysqli_fetch_array($result))
    {
        $arrayofrows[$count] = $row;
        $count++;
    }
  
    $conn->close();
    if ($num <= $count) {
        return $arrayofrows[$num]['SName'];
    }
}


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
    <h3><?php if (isset($_SESSION['login_user']))
            echo $_SESSION['login_user'];?>
    </h3>
    <h2 class="margin">Change Your Preference</h2>
    <div class="container">
        <form action="addpreference.php" method="post">
            <div class="btn-group dropdown" style="text-align-all: center">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" value="country"><?php include 'showpreference.php';?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" id="preference" name="preference">
                    <li value="Blues"><a href=" ">Blues</a ></li>
                    <li value="Classical"><a href="#">Classical</a ></li>
                    <li value="Country"><a href="#">Country</a ></li>
                    <li value="Jazz"><a href="#">Jazz</a ></li>
                    <li value="Pop"><a href="#">Pop</a ></li>
                    <li value="Rock"><a href="#">Rock</a ></li>
                    <li value="Holiday"><a href="#">Holiday</a ></li>
                </ul>
            </div>
            <input name="preference" type="submit">
        </form>
    </div>
</div>





<!-- Second Container -->
<div class="container-fluid bg-2 text-center">
    <h3 class="margin">Recommended Song:</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <p>
                <?php
                    $dislike1 = recommendSongs(0);
                    echo $dislike1;
                ?>
            </p>
            <form method="post" action="userlike.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" value= <?php echo "'{$dislike1}'" ?> >
                    </div>
                    <button type="submit" class="btn btn-danger">Like</button>
                </div>
            </form>

        </div>
        <div class="col-sm-4">
            <p>
                <?php
                    $dislike2 = recommendSongs(1);
                    echo $dislike2;
                ?>
            </p>
            <form method="post" action="userlike.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" value= <?php echo "'{$dislike2}'" ?> >
                    </div>
                    <button type="submit" class="btn btn-danger">Like</button>
                </div>
            </form>
        </div>
        <div class="col-sm-4">
            <p>
                <?php
                    $dislike3 = recommendSongs(2);
                    echo $dislike3;
                ?>
            </p>
            <form method="post" action="userlike.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" value= <?php echo "'{$dislike3}'" ?> >
                    </div>
                    <button type="submit" class="btn btn-danger">Like</button>
                </div>
            </form>
            <!-- img src="birds3.jpg" class="img-responsive margin" style="width:100%" alt="Image" -->
        </div>
    </div>






</div>


<!-- Third Container (Grid) -->
<!-- <div class="container-fluid bg-3 text-center">
    <h3 class="margin">Not found?</h3>
    <p><big>Tell us what you like:</big></p>
        <form method="post" action="userlike.php">  
        <div class = "margin"> 
            <div class="form-group" >
                <input name = "SName" type="text" class="form-control" >
            </div>
            <button class="btn btn-default" name="submit" type="submit">Like :)</button>
        </div>
        </form>
</div> -->


<div class="container-fluid bg-3 text-center">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    //var availableTags = allSongs();
    // var availableTags = [
    //   "ActionScript",
    //   "AppleScript",
    //   "Asp",
    //   "BASIC",
    //   "C",
    //   "C++",
    //   "Clojure",
    //   "COBOL",
    //   "ColdFusion",
    //   "Erlang",
    //   "Fortran",
    //   "Groovy",
    //   "Haskell",
    //   "Java",
    //   "JavaScript",
    //   "Lisp",
    //   "Perl",
    //   "PHP",
    //   "Python",
    //   "Ruby",
    //   "Scala",
    //   "Scheme"
    // ];
    //$( "#tags" ).autocomplete({
    //  source: availableTags
   // });
  });
  </script>
</head>
<body>

<h3 class="margin">Not found?</h3>
<p><big>Tell us what you like:</big></p>
<div class="ui-widget">
  <!-- <label for="tags">Tags: </label> -->
  <input id="tags">
  <form method="post" action="userlike.php">  
        <div class = "margin"> 
            <div class="form-group" >
                <input type = "hidden" name = "SName" type="text" class="form-control" >
            </div>
            <button class="btn btn-default" name="submit" type="submit">Like :)</button>
        </div>
        </form>

</div>
 
<!--  <form method="post" action="removelikesong.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName">
                    </div>
                    <button type="submit" class="btn btn-danger">Dislike</button>
                </div>
            </form> -->

<!--  <h3 class="margin">Not found?</h3>
    <p><big>Tell us what you like:</big></p>
        <form method="post" action="userlike.php">  
        <div class = "margin"> 
            <div class="form-group" >
                <input name = "SName" type="text" class="form-control" >
            </div>
            <button class="btn btn-default" name="submit" type="submit">Like :)</button>
        </div>
        </form> -->
<!-- 
<form method="post" action="removelikesong.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" \
                    </div>
                    <button type="submit" class="btn btn-danger">Dislike</button>
                </div>
            </form> -->

</body>

</div>

</html>








