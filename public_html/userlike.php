<?php
session_start(); 
// Starting Session
$error=''; // Variable To Store Error Message

$hostname = "engr-cpanel-mysql.engr.illinois.edu"; // usually is localhost
$db_user = "csprojec_admin"; // change to your database password
$db_password = "admin"; // change to your database password
$database = "csprojec_radiohub"; // provide your database name
$db_table = "User"; // your database table name
$conn = mysqli_connect($hostname, $db_user,$db_password, $database);
$SName= $_POST['SName'];
if (isset($_SESSION['login_user'])){
	$temp =  $_SESSION['login_user'];
}

		//$sql = "ADD Likes SET RName='$SName' WHERE Username= '$temp'";
		$sql = "INSERT INTO Likes (Username, RName) VALUES ('$temp', '$SName')";

		$query = mysqli_query($conn, $sql);
	if($query) {
	header("location: afterlogin.php"); 
	//echo "Thanks for signing up"; 
} else {
	echo "Error: ".  mysqli_error($conn);
}
	mysql_close($connection); // Closing Connection
	

?>