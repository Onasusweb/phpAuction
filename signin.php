 <?php 
 error_reporting(E_ALL);
 ini_set('display_errors', '1');
 $msg='';
 
 $an_error =0;
include('db.php');
 
include('header.php');
 if (isset($_POST['SubmitLogin'])){ //check to see if form was submitted.
 	echo '<h1 class="addPaddingH1">Status..</h1>';
 	signInForm(strip_tags(trim($_POST['username'])),sha1(strip_tags(trim($_POST['password']))));
 } elseif (isset($_POST['SubmitCreate'])){ //check to see if form was submitted for create.
 	echo '<h1 class="addPaddingH1">Status..</h1>';
 	createUser(strip_tags(trim($_POST['username'])),sha1(strip_tags(trim($_POST['password']))),strip_tags(trim($_POST['firstname'])),strip_tags(trim($_POST['lastname'])),strip_tags(trim($_POST['emailaddress'])),strip_tags(trim($_POST['useraddress'])),strip_tags(trim($_POST['uphone'])));
 } else {
 ?>
 		<h1 class="addPaddingH1">Sign-in</h1>
		<?php if ($msg <> "") { echo $msg; } ?>
         <div class="" id="loginModal">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Have an Account?</h3>
          </div>
          <div class="modal-body">
            <div class="well">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                <li><a href="#create" data-toggle="tab">Create Account</a></li>
              </ul><br>
              <div id="myTabContent" class="tab-content">
                <div class="tab-pane active in" id="login">
                  <form action='signin.php' method="POST">
                    <fieldset>    
                      <div class="form-group">
					      <label for="username">Username</label>
					      <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
					    </div>
 
                     <div class="form-group">
				      <label for="password">Password</label>
				      <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
				    </div>
				    
				    <button class="btn btn-primary" id="SubmitLogin" name="SubmitLogin">Submit</button>
 
                    </fieldset>
                  </form>                
                </div>
                <div class="tab-pane fade" id="create">
                  <form id="tab" action='signin.php' method="POST">
                  	<div class="form-group">
				      <label for="username">Username</label>
				      <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
				    </div>
				    <div class="form-group">
				      <label for="password">Password</label>
				      <input type="text" class="form-control" id="password" name="password" placeholder="Enter password">
				    </div>
				    <div class="form-group">
				      <label for="firstname">First Name</label>
				      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name">
				    </div>
                    <div class="form-group">
				      <label for="lastname">Last Name</label>
				      <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name">
				    </div>
                    <div class="form-group">
				      <label for="emailaddress">Email address</label>
				      <input type="text" class="form-control" id="emailaddress" name="emailaddress" placeholder="Enter email">
				    </div>
				    <div class="form-group">
				      <label for="useraddress">Address</label>
				       <textarea rows="3" class="form-control" id="useraddress" name="useraddress" placeholder="Enter address"></textarea>
				    </div>
				    <div class="form-group">
				      <label for="uphone">Phone</label>
				      <input type="text"  class="form-control" id="uphone" name="uphone" placeholder="Enter phone number">
				    </div>
 
                    <div>
                      <button class="btn btn-primary" id="SubmitCreate" name="SubmitCreate">Create Account</button>
                    </div>
                  </form>
                </div>
            </div>
          </div>
        </div>
 <!-- Sign-in layout from http://bootsnipp.com/snipps/loginregister-in-tabbed-interface -->
<?php  
 } 
include('footer.php');
?>