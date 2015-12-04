<?php
session_start();
//new function
function getlist() {
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
    // $sql = "SELECT SName FROM Song";

    $sql = "SELECT Song.SName FROM Song WHERE Song.SName NOT IN (SELECT Likes.Rname FROM Likes WHERE Likes.Username= '$temp')";

    $result = $conn->query($sql);
    $arrayofrows = array();

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            array_push($arrayofrows ,$row['SName']);
        }
    } else {
        echo "0 results";
    }
    $conn->close();

    return $arrayofrows;
    
}

/**
 * @param $num
 * @return mixed
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
    $sql = "SELECT Preference FROM User WHERE Username= '$temp'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $preference = $row["Preference"];
        }
    }

    $sql = "SELECT DISTINCT Song.SName FROM Song JOIN Likes JOIN User WHERE Song.SName = Likes.Rname AND Likes.Username = User.Username AND User.preference = '$preference' AND Song.SName NOT IN (SELECT Rname From Likes WHERE Username = '$temp')";

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

function showPreview($num) {
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

    $SName = recommendSongs($num);
    $sql = "SELECT URL FROM Song WHERE SName = '$SName'";
    $result = $conn->query($sql);
    $conn->close();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            return $row["URL"];
        }
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
                <li><a href="songsearch.php">Search Songs</a></li>
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
        <form name="addPreference" id="addPreference" action="addpreference.php" method="post">
            <div class="btn-group dropdown" style="text-align-all: center">
                <input class="span2" id="preference" name="preference" type="hidden">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php include 'showpreference.php';?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu" id="preference" name="preference">
                    <li onclick="$('#preference').val('Blues'); $('#addPreference').submit()"><a href="#">Blues</a ></li>
                    <li onclick="$('#preference').val('Classical'); $('#addPreference').submit()"><a href="#">Classical</a ></li>
                    <li onclick="$('#preference').val('Country'); $('#addPreference').submit()"><a href="#">Country</a ></li>
                    <li onclick="$('#preference').val('Jazz'); $('#addPreference').submit()"><a href="#">Jazz</a ></li>
                    <li onclick="$('#preference').val('Pop'); $('#addPreference').submit()"><a href="#">Pop</a ></li>
                    <li onclick="$('#preference').val('Rock'); $('#addPreference').submit()"><a href="#">Rock</a ></li>
                    <li onclick="$('#preference').val('Holiday'); $('#addPreference').submit()"><a href="#">Holiday</a ></li>
                </ul>
            </div>
        </form>
    </div>
</div>





<!-- Second Container -->
<div class="container-fluid bg-2 text-center">
    <h3 class="margin">Recommended Song:</h3><br>
    <div class="row">
        <div class="col-sm-4">
            <a href="<?php $preview1 = showPreview(0);
            echo $preview1; ?>">
                <?php
                    $dislike1 = recommendSongs(0);
                    echo $dislike1;
                ?>
            </a>
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
            <a href="<?php $preview2 = showPreview(1);
            echo $preview2; ?>">
                <?php
                    $dislike2 = recommendSongs(1);
                    echo $dislike2;
                ?>
            </a>
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
            <a href="<?php $preview3 = showPreview(2);
            echo $preview3; ?>">
                <?php
                    $dislike3 = recommendSongs(2);
                    echo $dislike3;
                ?>
            </a>
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

<div class="container-fluid bg-3 text-center">
   <head>
        <meta charset="utf-8">
        <title>jQuery UI Autocomplete - Default functionality</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
        <script src="//code.jquery.com/jquery-1.9.1.js"></script>
       <!--  // <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
        <script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
        <script>
            $(function() {
                //console.log("hey");
                var obj = '<?php echo json_encode(getlist()); ?>';
                var items = JSON.parse(obj);
                var availableTags = items;
                $( "#tags" ).autocomplete({
                    source: availableTags
                });
            });
            $(document).ready(function () {
            $('#tags').on('change', function () {
                $('#tagsname').html('You selected: ' + this.value);
            }).change();
            $('#tags').on('autocompleteselect', function (e, ui) {
                $('#tagsname').html('You selected: ' + ui.item.value);
                var songname = ui.item.value;
                $('#id1').val(songname);
            });
        });
        </script>
    </head>
    <body>


    <h3 class="margin">Not found?</h3>
    <p><big>Tell us what you like:</big></p>
    <div class="ui-widget">
        <!-- <label for="tags">Tags: </label> -->
        <input id="tags">
        <div id="tagsname"></div>
        <form method="post" action="userlike.php">
            <div class = "margin">
                <div class="form-group" >
                    <input type="hidden" name="SName" value= "" id = "id1">
                </div>
                <button class="btn btn-default" name="submit" type="submit">Like :)</button>

            </div>
        </form>

    </div>

    </body>
</html>
