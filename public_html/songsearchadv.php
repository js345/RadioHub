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
function filterSong($name)
    {
    	//return TRUE;
        return strpos($name, '\'') === FALSE && strpos($name, '"') === FALSE;
    }
function filterGenre($genre)
    {
        return $genre == "Blues" || $genre == "Classical" || $genre == "Country" || $genre == "Jazz" || $genre == "Pop" || $genre == "Rock" || $genre == "Holiday";
    }




//$sql = "SELECT Song.SName FROM Song WHERE Song.SName LIKE '%%".$song_key."%%' AND Song.ArtName LIKE '%%".$artist_key."%%' AND Song.Genre LIKE '%%".$genre."%%'";
$sql = "SELECT DISTINCT Song.SName FROM Song WHERE Song.SName LIKE '%%".$song_key."%%' AND Song.ArtName LIKE '%%".$artist_key."%%' AND Song.Genre LIKE '%%".$genre."%%' AND Song.SName NOT IN (SELECT RName FROM Likes WHERE Username = '$temp')";

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
        	$new_div = $dom->createElement("div", htmlspecialchars($row['SName']." "));
        	$button = $dom->createElement("a", "Like");
        	$button->setAttribute("class", "button");
        	$button->setAttribute("href", "likesong.php?argument1=".$row['SName']);
        	$new_div->appendChild($button);
        	

        	//<button class="btn btn-default" name="submit" type="submit">Search</button>
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
	    echo "0 results from our catalogs";
	    echo "<br>";
	    echo "fetching more songs from internet...";
	    echo "<br>";

	    $url_name = str_replace(" ", "+", $song_key);
	    if ($url_name == "")
	    	$url_name .= str_replace(" ", "+", $artist_key);
	    if ($url_name == "")
	    	$url_name .= str_replace(" ", "+", $genre);
	    echo $url_name;
		$url = "https://itunes.apple.com/search?term=";
		$url .= $url_name;
		$url .= "&entity=song";

		$songs = file_get_contents($url);
		if (!$songs)
			echo 'No more info about your song on the internet';
		$json_songs = json_decode($songs, true);
		if (!$json_songs)
		{
			die();
		}
			

		$dom = new DOMDocument();
	    $dom->validateOnParse = true; //<!-- this first

        	//echo $dom->load("songsearch.php");
        libxml_use_internal_errors(true);
        $dom->loadHTMLFile("songsearch.php");
        libxml_use_internal_errors(false);
		$dom->preserveWhiteSpace = false;
		$results = $dom->getElementById("results");

		if ($json_songs["resultCount"] == "0")
			echo "No more info from internet";

		foreach ($json_songs["results"] as $item) {
		//insert Song data into DB
			if (filterSong($item["trackName"]) && filterGenre($item["primaryGenreName"]))
			{

				$new_div = $dom->createElement("div", htmlspecialchars($item["trackName"]." "));

        		$adlk = $dom->createElement("a", "Add and Like ");
        		$adlk->setAttribute("class", "btn-large");
       		 	$adlk->setAttribute("href", "addandlike.php?argument1=".$item["trackName"]."&argument2=".$item["artistName"]."&argument3=".$item["albumName"]."&argument4=".$item["releaseDate"]."&argument5=".$item["previewUrl"]."&argument6=".$item["primaryGenreName"]);
       		 	$new_div->appendChild($adlk);

       		 	$prev = $dom->createElement("a", "Preview");
        		$prev->setAttribute("class", "btn");
       		 	$prev->setAttribute("href", $item["previewUrl"]);
   		     	$new_div->appendChild($prev);
        	
        		//<button class="btn btn-default" name="submit" type="submit">Search</button>
        		//$div->div = $row['SName'];
				// We insert the new element as root (child of the document)
				$results->appendChild($new_div);

				/*
				$query = sprintf("INSERT IGNORE INTO Album (Name, Year)
				VALUES ('%s', '%s');", mysql_real_escape_string($item["collectionName"]), mysql_real_escape_string($item["releaseDate"]));

				$result = mysql_query($query, $link);
				if (!$result) {
    				//die('Invalid query: ' . mysql_error());
    				echo(mysql_error());
  			  		echo("\n");
				}
				*/
		//
				//$album_ids[$i] = $item["collectionId"];
				//$album_names[$i] = $item["collectionName"];
				//$album_years[$i] = $item["releaseDate"];
			}
		}
		$nav = $dom->getElementById("navbar");
	    $nav->parentNode->removeChild($nav);
	    $srch = $dom->getElementById("searchsection");
		$srch->parentNode->removeChild($srch);
	    echo $dom->saveHTML();
	}


$conn->close();


?>