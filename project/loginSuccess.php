<?php

$authentication=$_GET['authenticate'];
$username=$_GET['username'];
$password=$_GET['password'];
$database=$_GET['database'];
$host=$_GET['host'];
$port=$_GET['port'];

if($authentication==1)
{
	if(strlen($username)==0 or strlen($password)==0 or strlen($database)==0)
	{
	?>

	<script>
	alert("Fields can not be left blank.");
	window.location.href="index.php";
	</script>

	<?php

	}
	else
	{
		session_start();

		$_SESSION['username']=$username;
		$_SESSION['password']=$password;
		$_SESSION['database']=$database;


		?>



		<form name=myform action=index1.php method=get>
<!--		<input type=hidden name='username' value="<?php echo $username; ?>">
		<input type=hidden name='password' value="<?php echo $password; ?>">
		<input type=hidden name='database' value="<?php echo $database; ?>">-->
		<input type=hidden name='authenticate' value="<?php echo $authentication; ?>">
		<input type=hidden name='host' value="<?php echo $host; ?>">
		<input type=hidden name='port' value="<?php echo $port; ?>">

		</form>

<!--
		$_SESSION['username']=$username;
		$_SESSION['password']=$password;
		$_SESSION['database']=$database;
		$_SESSION['authenticate']=$authentication;
		$_SESSION['host']=$host;
		$_SESSION['port']=$port;
-->
		
		<script>
		//window.location.href="index1.php";
		document.myform.submit();
		</script>
	<?php

	}

}
else
{

		session_start();
		//$_SESSION[]

?>

		<form name=myform action=index1.php method=get>
<!--		<input type=hidden name='username' value="<?php echo $username; ?>">
		<input type=hidden name='password' value="<?php echo $password; ?>">
		<input type=hidden name='database' value="<?php echo $database; ?>">-->
		<input type=hidden name='authenticate' value="<?php echo $authentication; ?>">
		<input type=hidden name='host' value="<?php echo $host; ?>">
		<input type=hidden name='port' value="<?php echo $port; ?>">

		</form>




<?php
	/*	$_SESSION['username']=$username;
		$_SESSION['password']=$username;
		$_SESSION['database']=$username;
		$_SESSION['authenticate']=$authentication;
*/	?>	
		<script>
//		window.location.href="index1.php";
		document.myform.submit();
		</script>
	<?php



}

?>


<!--
<?php
	session_start();
	if(isset($_SESSION['uname']))
	{
	?>
	
	<div align=right>
	<?php
		echo "Hello ".$_SESSION['uname'];
?>
		
		<a href="Logout.php">Logout</a>
		
	</div>

<br><br>
<div align=center>
<form action=table1.php>
<input type="submit" value="Generate Table(Change Width on different Page)">
</form>

<form action="table2.php">
<input type="submit" value="Generate Table(Change Width on same Page.)">
</form>
</div>

<?php

	}
	else
	{
		echo "Login First";
		?>
		<a href="login.php">Go to Login Page</a>
		<?php
		
	}

?>

-->
