<html>
You inserted

<?php
$servername = "engr-cpanel-mysql.engr.illinois.edu";
$username = "csprojec_admin";
$password = "admin";
$dbname = "csprojec_radiohub";

// create connection
$conn = new mysqli($servername,$username,$password,$dbname);

// checking connection
if (mysqli_connect_error()) {
	die("Database connection failed: " .mysqli_connect_error());
}
//echo "Connected successfully<br><br>";
$sql= "SELECT * FROM Album";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		//echo $row["Year"];
	}
}

//get input from html
echo $_POST["insert"];

mysqli_close($conn);
?>

</html>