<?php
	session_start();
	if(isset($_SESSION['username']))
	{
		session_destroy();		
		echo '<script type="text/javascript">'; 
		//echo 'alert("wrong Username or Password");'; 
		echo 'window.location.href = "index.php";';
		echo '</script>';
	}
	else
	{

		echo '<script type="text/javascript">'; 
		//echo 'alert("wrong Username or Password");'; 
		echo 'window.location.href = "index.php";';
		echo '</script>';
	}
?>
