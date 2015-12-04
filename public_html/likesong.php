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

if (isset($_SESSION['login_user'])) {
    $temp = $_SESSION['login_user'];
}
//echo $argv[1];
//$sql = "SELECT RName FROM Likes WHERE Username= '$temp'";

//$rname = $argv[1];
$SName = $_GET['argument1'];
$sql = "SELECT Song.SName From Song WHERE Song.SName = '$SName'";
$query = $conn->query($sql);
if ($result->num_rows <= 0) {
    // output data of each row
    header("location: changePreference.php");
}
$sql = "INSERT INTO Likes (Username, RName) VALUES ('$temp', '$SName')";

$result = $conn->query($sql);

$sql = "UPDATE Song SET Song.Ranking = Song.Ranking + 1 WHERE Song.SName = '$SName'";

$query = $conn->query($sql);
header('Location: songsearch.php');
?>