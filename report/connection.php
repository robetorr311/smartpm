 <?php
$servername = "localhost";
$username = "root";
$password = "P@ssw0rd";
$dbname = "roofingcrm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $logo='logo.png';
    $favicon='favicon.png';
	$query1 = "SELECT * FROM admin_setting";
    $results1 = mysqli_query($conn, $query1);
    
	  if ($results1->num_rows > 0) {
	      
		  while($row = $results1->fetch_assoc()) {
			  
			  $logo=$row['url'];
			  $favicon=$row['favicon'];
			 
		  }
	  }
?>