<?php
session_start(); 
// Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['name']) || empty($_POST['password'])) {
		$error = "Username or Password is invalid";
		header("location: login.php");
	}
	else{
	// Define $username and $password
		$name=$_POST['name'];
		$password=$_POST['password'];
	// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		$connection = mysql_connect("engr-cpanel-mysql.engr.illinois.edu", "csprojec_admin", "admin");
	// To protect MySQL injection for Security purpose
		$name = stripslashes($name);
		$password = stripslashes($password);
		$name = mysql_real_escape_string($name);
		$password = mysql_real_escape_string($password);
	// Selecting Database
		$db = mysql_select_db("csprojec_radiohub", $connection);
	// SQL query to fetch information of registerd users and finds user match.
		$query = mysql_query("select * from User where Password='$password' AND Username='$name'", $connection);
		if($query)
			$rows = mysql_num_rows($query);
		else{
			die("something failed");
			echo "fail";
		}
		if ($rows == 1) {
			$_SESSION['login_user']=$name; // Initializing Session
			$_SESSION['user_password']=$password;
			header("location: afterlogin.php"); // Redirecting To Other Page
		} 
		else {
			$error = "Username or Password is invalid";
			header("location: login.php");
			echo "invalid";
		}
		
	mysql_close($connection); // Closing Connection
	}
}
?>