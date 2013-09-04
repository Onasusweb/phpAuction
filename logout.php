<?php 
setcookie("AttendeeUserName", "", time()-3600);
header("Refresh: 0; URL=index.php");
?>