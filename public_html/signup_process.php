<?php
$hostname = "engr-cpanel-mysql.engr.illinois.edu"; // usually is localhost
$db_user = "csprojec_admin"; // change to your database password
$db_password = "admin"; // change to your database password
$database = "csprojec_radiohub"; // provide your database name
$db_table = "User"; // your database table name
$conn = mysqli_connect($hostname, $db_user,$db_password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$name = $_POST['name'];
$password = $_POST['password'];

$sql = "INSERT INTO User (Username, Password) VALUES ('$name', '$password')";

$query = mysqli_query($conn, $sql);

/*
* After Query, Create a PHP SESSION
*/

if($query) {
	header("location: aftersignup.html"); 
	//echo "Thanks for signing up"; 
} else {
	echo "Error: ".  mysqli_error($conn);
}

mysqli_close($conn);


?>