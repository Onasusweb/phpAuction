<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">phpAuction</a>
        <div class="nav-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
           <!-- <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li> --> 
          	<?php 
          	if (isset($_COOKIE["AttendeeUserName"]))
          	{
          		echo ' <li><a href="logout.php">Logout</a></li>';
          	} else {
				echo ' <li><a href="signin.php">Sign-in</a></li>';
			}
          	?>
          
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>