 <?php
	$servername = "ormeaux-29.mysql.database.azure.com";
	$username = "ormeaux@ormeaux-29";
	$password = "Password29";
	$dbname = "ormeaux";

// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname, MYSQLI_CLIENT_SSL);
// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}
?>
