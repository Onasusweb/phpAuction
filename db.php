<?php
//Connection to mysql.
function dbConnection($host,$user,$pass,$db) {
	$mysqli = new mysqli($host, $user, $pass, $db);
	if($mysqli->connect_error)
		die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
	return $mysqli;
}

//Select auction items for main screen
function frontPageSelectListings(){
	$mysqli = dbConnection('localhost','theagent','temppass','auctionsite');
	$itemListingli='';
	$sql='SELECT id, ititle,isummary,ipicture FROM items ORDER BY id DESC;';
	$rs=$mysqli->query($sql);
	 
	if($rs === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
	  $rows_returned = $rs->num_rows;
	  $rs->data_seek(0);
	  while($row = $rs->fetch_assoc()){
		$item_id=$row['id'];
		$title=stripslashes($row['ititle']);
		$summary=stripslashes($row['isummary']);
		$picture=urldecode(stripslashes($row['ipicture']));
		
		if (isset($_COOKIE["AttendeeUserName"]))
		{
			$itemListingli.='<li class="col-lg-4">
			  <div class="thumbnail text-center">
			    <img src="'.$picture.'" alt="'.$title.': Image" class="img-thumbnail img-responsive">
			    <div class="caption text-left">
			      <h3>'.$title.'</h3>
			      <p>'.$summary.'</p>
			      <p class="text-center"><a class="openmodal btn btn-primary btn-lg" href="#auctionmodals" role="button" data-extrastuff="'.$title.'" data-toggle="modal" data-id="'.$item_id.'">Bid Now/More info</a></p>
			    </div>
			  </div>
			</li>';
		} else {
			$itemListingli.='<li class="col-lg-4">
			  <div class="thumbnail text-center">
			    <img src="'.$picture.'" alt="'.$title.': Image" class="img-thumbnail img-responsive">
			    <div class="caption text-left">
			      <h3>'.$title.'</h3>
			      <p>'.$summary.'</p>
			      <p class="text-center"><a class=" btn btn-primary btn-lg" href="signin.php">Sign-up to Bid</a></p>
			    </div>
			  </div>
			</li>';
		}
		
		
	  }
	}
	echo $itemListingli;
	$rs->free();
}

//get info for modal item - use ajax
function frontModalListings($item_id){
	$mysqli = dbConnection('localhost','theagent','temppass','auctionsite');
	$modalInfo='';

	if (isset($_COOKIE["AttendeeUserName"]))
	{
		$cookiedUser=$_COOKIE["AttendeeUserName"];
	}
	$sql="SELECT items.isummary, items.ipicture, items.itemadded, items.ilastdate, items.iincrement, bids.bAmount, bids.dateAdded, people.id as userid, people.usrfirst FROM items INNER JOIN bids ON items.id = bids.itemId INNER JOIN people ON people.id = bids.userId WHERE items.id ='".$item_id."' ORDER BY bids.id DESC LIMIT 1";
	$rs=$mysqli->query($sql);

	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			$summary=stripslashes($row['isummary']);
			$picture=urldecode(stripslashes($row['ipicture']));
			$added=stripslashes($row['itemadded']);
			$closing=stripslashes($row['ilastdate']);
			$increment = stripslashes($row['iincrement']);
			$lastBid = stripslashes($row['bAmount']);
			$lastBidDate = stripslashes($row['dateAdded']);
			$userid = stripslashes($row['userid']);
			$user = stripslashes($row['usrfirst']);
			$nextBid=$increment+$lastBid;
			$modalInfo.='<div class="row">
					  <div class="col-lg-2">
				             <img src="'.$picture.'" alt="Item Image" class="img-thumbnail">
					  </div>
					  
					  <div class="col-lg-10">
					  	<p>Auction Span: '.$added.'until '.$closing.'<br>
					  	Bid increment: $'.$increment.'</p>
				        <p>
				          '.$summary.'
				        </p>
				       
						<table class="table table-striped table-condensed scrolltable">
							<thead>
								<tr>
								<th>Current High Bidder</th>
								<th>Date</th>
								<th>Amount</th>                                          
								</tr>
							</thead>   
							<tbody>
								<tr>
									<td>'.$user.'</td>
									<td>'.$lastBidDate.'</td>
									<td>$'.$lastBid.'</td>
								</tr>
								<tr>
									<td colspan="3">
										<small><a href="listing.php?id='.$item_id.'">View full list of bidders</a></small>
									</td>
								</tr>
							</tbody>
						</table>
						
						<form class="form-inline" method="post" action="bid.php">
							<div class="col-lg-5"><input type="text" class="form-control " name="nextbid" value="'.$nextBid.'"></div>
							<input type="hidden" name="item_id" id="item_id" value="'.$item_id.'">
							<input type="hidden" name="username" id="username" value="'.$userid.'">
							<input type="hidden" name="cookiedUser" id="cookiedUser" value="'.$cookiedUser.'">
					  		<button type="submit" class="btn btn-primary">Save Bid</button>
						</form>
				      </div>
					</div>';
		}
	}
	echo $modalInfo;
	$rs->free();
}

//View entire listing information
function fullItemInfo($item_id){
	$mysqli = dbConnection('localhost','theagent','temppass','auctionsite');
	$sql="SELECT ititle,isummary,ipicture,itemadded,ilastdate,iincrement FROM items WHERE id ='".$item_id."' ORDER BY id DESC LIMIT 1;";
	$rs=$mysqli->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			
			$title=stripslashes($row['ititle']);
			$summary=stripslashes($row['isummary']);
			$picture=urldecode(stripslashes($row['ipicture']));
			$added=stripslashes($row['itemadded']);
			$closing=stripslashes($row['ilastdate']);
			$increment = stripslashes($row['iincrement']);
			
			
			$listingInfo='
				<h4><strong>'.$title.'</strong></h4>
				<div class="row">
					  <div class="col-lg-2">
				             <img src="'.$picture.'" alt="Item Image" class="img-thumbnail">
					  </div>
				
					  <div class="col-lg-10">
					  	<p>Auction start: '.$added.'<br>
					  	Auction close: '.$closing.'<br>
					  	Bid increment: $'.$increment.'</p>
				        <p>
				          '.$summary.'
				        </p>
				  
						<table class="table table-striped table-condensed scrolltable">
							<thead>
								<tr>
								<th>Bidder</th>
								<th>Date</th>
								<th>Amount</th>
								</tr>
							</thead>
							<tbody>';
		}
	}
	
	//get bids
	$sql="SELECT bids.bAmount, bids.dateAdded, people.id as userid, people.usrfirst FROM items INNER JOIN bids ON items.id = bids.itemId INNER JOIN people ON people.id = bids.userId WHERE items.id ='".$item_id."'";
	$rs=$mysqli->query($sql);

	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			$lastBid = stripslashes($row['bAmount']);
			$lastBidDate = stripslashes($row['dateAdded']);
			$userid = stripslashes($row['userid']);//userid
			$user = stripslashes($row['usrfirst']);
				
			$listingInfo.='
								<tr>
									<td>'.$user.'</td>
									<td>'.$lastBidDate.'</td>
									<td>$'.$lastBid.'</td>
								</tr>';
		}
	}
	$nextBid=$increment+$lastBid;
	if (isset($_COOKIE["AttendeeUserName"]))
	{
		$cookiedUser=$_COOKIE["AttendeeUserName"];
	}
	$listingInfo.='
							</tbody>
						</table>

						<form class="form-inline" method="post" action="bid.php">
							<div class="col-lg-5"><input type="text" class="form-control " name="nextbid" value="'.$nextBid.'"></div>
							<input type="hidden" name="item_id" id="item_id" value="'.$item_id.'">
							<input type="hidden" name="username" id="username" value="'.$userid.'">
							<input type="hidden" name="cookiedUser" id="cookiedUser" value="'.$cookiedUser.'">
					  		<button type="submit" class="btn btn-primary">Save Bid</button>
						</form>
				      </div>
					</div>';
	echo $listingInfo;
	$rs->free();
}


//TODO: Add bid to auction
function addbid($form_user,$form_itemid,$form_bid,$form_lastbid){
	$mysqli = dbConnection('localhost','theagent','temppass','auctionsite');
	$an_error=0;
	$displayUserMessage='';
	if ( (ctype_digit($form_itemid)) && (ctype_digit($form_lastbid))  && (ctype_digit($form_bid)) ) {
		$v1="'" . $mysqli->real_escape_string($form_user) . "'";
		$sql="SELECT id FROM people WHERE username =$v1 LIMIT 1";
		$rs=$mysqli->query($sql);
		if($rs === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
		} else {
				$rows_returned = $rs->num_rows;
				$rs->data_seek(0);
				while($row = $rs->fetch_assoc()){
					$id = stripslashes($row['id']);
				}	
		}
		$rs->free();
		
		if ($id == $form_lastbid){
			echo '<div class="alert">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Error!</strong> You cannot bid twice on the same item if no one has outbid you.
			</div>
			<p>Press the back button and try a different item.</p>		
		';
		} else {
			$v1b="'" . $mysqli->real_escape_string($id) . "'";
			$v2="'" . $mysqli->real_escape_string($form_itemid) . "'";
			$v3="'" . $mysqli->real_escape_string($form_bid) . "'";
			$sql="INSERT INTO `auctionsite`.`bids` (`itemId`, `userId`, `bAmount`, `dateAdded`) VALUES($v2, $v1b, $v3, NOW())";
			
			if($mysqli->query($sql) === false) {
				trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
			} else {
				$last_inserted_id = $mysqli->insert_id;
				$affected_rows = $mysqli->affected_rows;
			}
			
			echo '<div class="alert alert-success">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Success!</strong> Your bid has been successfully added. Press <a href="index.php">here</a> to view all listings.
			</div>';
		}
	} else {
	 	echo '<div class="alert">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Error!</strong> Page not submitted properly
			</div>
			<p>Press the back button and try again.</p>		
		';
	}
	
}
//login to Admin Panel
function signInForm($form_user,$form_pass){
	$mysqli = dbConnection('localhost','theagent','temppass','auctionsite');
	$an_error=0;
	$displayUserMessage='';
	$v1="'" . $mysqli->real_escape_string($form_user) . "'";
	$v2="'" . $mysqli->real_escape_string($form_pass) . "'";
	$id=0;
	//$sql="INSERT INTO tbl (col1_varchar, col2_number) VALUES ($v1,10)"
	
	$sql="SELECT id, username,usrpass FROM people WHERE username =$v1 AND usrpass=$v2 LIMIT 1";
	$rs=$mysqli->query($sql);
	
	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			$id = stripslashes($row['id']);
			$uName = stripslashes($row['username']);
			$thepass = stripslashes($row['usrpass']);
		}	
	}
	if ($id == 0){
		echo $displayUserMessage = '<div class="alert">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Error!</strong> Unsuccessful login attempt.
			</div>
			<p>Press the back button and try again.</p>		
		';	
		include('footer.php');
	} else {
		$expire=time()+60*60*24*30;
		setcookie("AttendeeUserName", $uName, $expire);
		echo $displayUserMessage = '
			<div class="alert alert-success">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Success!</strong> You have seccussfully logged in. Press <a href="index.php">here</a> to view the listings.
			</div>';
	}
}

//Create user to Admin Panel
function createUser($form_user,$form_pass,$form_firstname,$form_lastname,$form_email,$form_address,$form_phone){
	$mysqli = dbConnection('localhost','theagent','temppass','auctionsite');
	$an_error=0;
	$displayUserMessage='';
	$uName='';
	$uemail='';
	$v1="'" . $mysqli->real_escape_string($form_user) . "'";
	$v2="'" . $mysqli->real_escape_string($form_pass) . "'";
	$v3="'" . $mysqli->real_escape_string($form_firstname) . "'";
	$v4="'" . $mysqli->real_escape_string($form_lastname) . "'";
	$v5="'" . $mysqli->real_escape_string($form_email) . "'";
	$v6="'" . $mysqli->real_escape_string($form_address) . "'";
	$v7="'" . $mysqli->real_escape_string($form_phone) . "'";
	
	$msg='';
	$sql="SELECT usremail,username FROM people WHERE username =$v1 or usremail=$v5 LIMIT 1";
	$rs=$mysqli->query($sql);

	if($rs === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
	} else {
		$rows_returned = $rs->num_rows;
		$rs->data_seek(0);
		while($row = $rs->fetch_assoc()){
			$uName = stripslashes($row['username']);
			$uemail = stripslashes($row['usremail']);
		}
	}
	//usrfirst, usrlast, usremail,usrpass,username,address,userphone
	//strlen($str)
	if (trim($form_user) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>Username must be entered.</li>";
	}
	
	if (trim($form_pass) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>A password at is required.</li>";
	}
	
	if (trim($form_firstname) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>First name must be entered.</li>";
	}
	
	if (trim($form_lastname) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>Last name must be entered.</li>";
	}
	
	if (trim($form_email) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>E-mail is required.</li>";
	} elseif (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $form_email)) {
		$an_error = $an_error + 1;
		$msg .="<li>Email address is invalid.</li>";
	}
	
	if (trim($form_address) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>Address must be entered.</li>";
	}
	
	if (trim($form_phone) == '') {
		$an_error = $an_error + 1;
		$msg .="<li>Phone must be entered.</li>";
	}
	
	if ($form_user == $uName){
		$msg .="<li>Username already exists.</li>";
	}
	if ($form_email == $uemail){
		$msg .="<li>Email address already exists.</li>";
	}
	
	
	if ($an_error <>0) {
		echo $displayUserMessage = '<div class="alert">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Error!</strong> Information not filled in correctly. A summary is below.
			</div>
			<p><strong>Summary:</strong></p>
			<ul>
				'.$msg.'
			</ul>
			
			<p>Press the back button and try again.</p>
		';
		include('footer.php');
	} else {
		$sql="INSERT INTO `auctionsite`.`people` (`usrfirst`, `usrlast`, `usremail`, `usrpass`, `usrbids`, `username`, `address`, `userphone`)VALUES($v3, $v4, $v5, $v2, NULL, $v1, $v6, $v7)";
		
		if($mysqli->query($sql) === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $mysqli->error, E_USER_ERROR);
		} else {
			$last_inserted_id = $mysqli->insert_id;
			$affected_rows = $mysqli->affected_rows;
		}
		
		$expire=time()+60*60*24*30;
		setcookie("AttendeeUserName", $form_user, $expire);
		echo $displayUserMessage = '
			<div class="alert alert-success">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Success!</strong> Your account has been created, and you are now signed in. Press <a href="index.php">here</a> to view the listings.
			</div>';
	}
}

?>