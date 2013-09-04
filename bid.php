 <?php 
 error_reporting(E_ALL);
 ini_set('display_errors', '1');

 include('db.php');
 include('header.php');
 
 echo '<h1 class="addPaddingH1">Bidding...</h1>';
 if ( (isset($_POST['item_id'])) && (isset($_POST['cookiedUser'])) && (isset($_POST['nextbid'])) && (isset($_POST['username']))  ){
 	addbid($_POST['cookiedUser'],$_POST['item_id'],$_POST['nextbid'],$_POST['username']);
 } else {
 	echo '<p>Must be logged in to bid.</p>';
 }

 include('footer.php');
?>