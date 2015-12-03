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

//if (isset($_SESSION['login_user'])){
//	$temp =  $_SESSION['login_user'];
//}

$sql = "SELECT Song.SName FROM Song WHERE Song.SName LIKE '%%".$song_key."%%' AND Song.ArtName LIKE '%%".$artist_key."%%' AND Song.Genre LIKE '%%".$genre."%%'";

$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    // output data of each row
	    $dom = new DOMDocument();
	    $dom->validateOnParse = true; //<!-- this first

        	//echo $dom->load("songsearch.php");
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile("songsearch.php");
        libxml_use_internal_errors(false);
		$dom->preserveWhiteSpace = false;
		$results = $dom->getElementById("results");
		$results->nodeValue = "Search Results:";
	    
	    while($row = $result->fetch_assoc()) {
        	
        	//->getElementById("results");
        	$new_div = $dom->createElement("div", $row['SName']);
        	$button = $dom->createElement("button", "Like");
        	$new_div->appendChild($button);
        	//$div->div = $row['SName'];
			// We insert the new element as root (child of the document)
			$results->appendChild($new_div);

	       	//echo $row['SName'];
	        //<button class="btn btn-default" name="submit" type="submit">Add</button>
	        //echo "<br>";
	    }
	    $nav = $dom->getElementById("navbar");
	    $nav->parentNode->removeChild($nav);
	    $srch = $dom->getElementById("searchsection");
		$srch->parentNode->removeChild($srch);
	    echo $dom->saveHTML();
	} else {
	    echo "0 results";
	    echo "<br>";
	    echo "fetching more songs from internet...";


	}


$conn->close();


?>