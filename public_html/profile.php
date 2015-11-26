<?php
session_start();
function showSongs($num) {
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

    $sql = "SELECT RName FROM Likes WHERE Username= '$temp'";

    $result = $conn->query($sql);
    $arrayofrows = array();
    $count = 0;
    while($row = mysqli_fetch_array($result))
    {
        $arrayofrows[$count] = $row;
        $count++;
    }
    /*
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo $row['RName'];
            //echo "<br>";
        }
    } else {
        echo "0 results";
    }*/
    $conn->close();
    if ($num <= $count) {
        return $arrayofrows[$num]['RName'];
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

<!-- First Container -->
<div class="container-fluid bg-1 text-center">
    <h3><?php if (isset($_SESSION['login_user']))
            echo $_SESSION['login_user'];?>
    </h3>
    <h2 class="margin">Your Preference</h2>
    <!-- img src="bird.jpg" class="img-responsive img-circle margin" style="display:inline" alt="Bird" width="350" height="350" -->
    <h>
        <?php include 'showpreference.php';?>
    </h>

</div>

<!-- Second Container -->
<div class="container-fluid bg-2 text-center">
    <h3 class="margin">Your Favorite Songs</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <p>
                <?php
                    $like1 = showSongs(0);
                    echo $like1;
                ?>
            </p>
            <form method="post" action="removelikesong.php">
                <div class = "row">
                    <div class="form-group" >
                        <input type="hidden" name="SName" value= <?php echo "'{$like1}'" ?> >
                    </div>
                    <button type="submit" class="btn btn-danger">Dislike</button>
                </div>
            </form>

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


<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">
    <h3 class="margin">Find More Songs?</h3>
    <p>Click the button to find more songs. </p>
    <a href="#" class="btn btn-default btn-lg">
        <span class="glyphicon glyphicon-search"></span> Search
    </a>
</div>

<!-- Footer -->
<footer class="container-fluid bg-4 text-center">
    <p><a href="index.html">RadioHub</a></p>
</footer>

</body>
</html>
