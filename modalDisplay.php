 <?php 
 error_reporting(E_ALL);
 ini_set('display_errors', '1');
 
 $theItemID= $_GET['id'];
 if (ctype_digit($theItemID)) {
 	 include('db.php');
 	 frontModalListings($theItemID);
 } else {
 	echo "<p>Please use the auction site to access this page.\n";
 }
 
 ?>