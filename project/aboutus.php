<?php

session_start();

$_SESSION['temp']="sandesh";

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
	<link rel='stylesheet' type='text/css' href='styles.css' />
	<link rel='stylesheet' type='text/css' href='styles1.css' />
	<script src='jquery.min.js'></script>
	<script type='text/javascript' src='menu_jquery.js'></script>
	 <link rel="stylesheet" href="menu.css" type="text/css" media="screen">
	<link rel="stylesheet" href="temp.css" type="text/css" media="screen">

        <link href="css/modal.css" rel="stylesheet" type="text/css" />








</head>
<body>
<header> <!--holds the site name or logo-->
<img src="images/mongo_logo.jpg" height=70px width=250px></img>


</header>

<div id="container">
<nav1> <!--Left hand column - if used for something other than navigation change its name-->

</nav1>


<section id="content"> <!--Right hand column-->


<br><br><br><br><br><br>

<center>
<font size=5>MonogoAdmin
<br>
GUI-Interface for MongoDB
<br>





</section>
</div> <!--end container-->

<script>
function displayDbform($t)
{

	if($t==1)
	{
		var temp=document.getElementById("dbname");

		temp.style.visibility="visible";
	
		var temp=document.getElementById("uname");

		temp.style.visibility="visible";

		var temp=document.getElementById("pwd");

		temp.style.visibility="visible";
	}
	else
	{
		var temp=document.getElementById("dbname");

		temp.style.visibility="hidden";
	
		var temp=document.getElementById("uname");

		temp.style.visibility="hidden";

		var temp=document.getElementById("pwd");

		temp.style.visibility="hidden";


	}


}
</script>

</body>
</html>
