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

<form action="index1.php">

<table>
<tr>

<td>Host Name</td>
<td>:</td>
<td><input type=text name=host required="required"></td>

</tr>

<tr>

<td>Port Number</td>
<td>:</td>
<td><input type=text name=port value=27017 required="required"></td>
</tr>

<tr>
<td>Authentication</td>
<td>:</td>
<td><input type=radio name=authenticate value=1 onclick="displayDbform(this.value)">Yes</td>
</tr>

<tr>
<td></td>
<td></td>
<td><input type=radio name=authenticate value=0 checked=checked onclick="displayDbform(this.value)">No</td>
</tr>


<tr id=dbname style="visibility:hidden;">
<td>Database Name</td>
<td>:</td>
<td><input type=text name=database></td>
</tr>


<tr id=uname style="visibility:hidden;">
<td>Username</td>
<td>:</td>
<td><input type=text name=username></td>
</tr>

<tr id=pwd style="visibility:hidden;">
<td>Password</td>
<td>:</td>
<td><input type=password name=password></td>
</tr>

<tr></tr>
</table>
<br>
<table>
<tr>

<td><input type=submit value=Connect></td>
<td><input type=button value=clear></td>
</tr>

</table>

</form>

</section>
</div> <!--end container-->

<script>
function displayDbform($t)
{

//	alert($t);
	//var temp=document.getElementById("sort_form").style.visibility="visible";

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
