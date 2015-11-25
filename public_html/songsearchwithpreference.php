<?php
session_start();
$hostname = "engr-cpanel-mysql.engr.illinois.edu"; // usually is localhost
$db_user = "csprojec_admin"; // change to your database password
$db_password = "admin"; // change to your database password
$database = "csprojec_radiohub"; // provide your database name
$db_table = "User"; // your database table name
$conn = new mysqli($hostname, $db_user, $db_password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if (isset($_SESSION['login_user'])){
	$temp =  $_SESSION['login_user'];
}

$sql = "SELECT Song.SName FROM Song, User WHERE Username= '$temp' AND User.Preference = Song.Genre";

$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	       	echo $row['SName'];
	        //<button class="btn btn-default" name="submit" type="submit">Add</button>
	        echo "<br>";
	    }
	} else {
	    echo "0 results";
	}


$conn->close();


?>