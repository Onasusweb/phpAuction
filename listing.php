 <?php 
 error_reporting(E_ALL);
 ini_set('display_errors', '1');

 include('header.php');
 
 echo '<h1 class="addPaddingH1">Viewing Full Listing</h1>';
 
 $theItemID= $_GET['id'];
 if (ctype_digit($theItemID)) {
 	include('db.php');
 	//echo 'ID used.';
 	fullItemInfo($theItemID);
 } else {
 	echo "<p>Please use the auction site to access this page.\n";
 }
 
 ?>

<?php include('footer.php');?>