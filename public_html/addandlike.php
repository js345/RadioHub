<?php
ob_start();
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
$sname = $_GET['argument1'];
$artname = $_GET['argument2'];
$albname = $_GET['argument3'];
$albyear = $_GET['argument4'];
$url = $_GET['argument5'];
$genre = $_GET['argument6'];

$sql = "INSERT INTO Likes (Username, RName) VALUES ('$temp', '$rname')";

				//$query = sprintf("INSERT IGNORE INTO Album (Name, Year)
				//VALUES ('%s', '%s');", mysql_real_escape_string($item["collectionName"]), mysql_real_escape_string($item["releaseDate"]));

				$sql1 = "INSERT IGNORE INTO Song (ArtName, Genre, Ranking, SName, URL) VALUES ('$artname', '$genre', 0, '$sname', '$url')";

				$sql2 = "INSERT IGNORE INTO Artist (Name) VALUES ('$artname')";

				$sql3 = "INSERT IGNORE INTO Album (Name, Year) VALUES ('$albname', '$albyear')";
				$sql4 = "INSERT INTO Likes (Username, RName) VALUES ('$temp', '$sname')";

				echo $result = $conn->query($sql1);
				echo $result = $conn->query($sql2);
				echo $result = $conn->query($sql3);
				echo $result = $conn->query($sql4);

				if (!$result) {
    				//die('Invalid query: ' . mysql_error());
    				echo(mysql_error());
  			  		echo("\n");
				}
				
				//$album_ids[$i] = $item["collectionId"];
				//$album_names[$i] = $item["collectionName"];
				//$album_years[$i] = $item["releaseDate"];




header('Location: songsearch.php');
?>