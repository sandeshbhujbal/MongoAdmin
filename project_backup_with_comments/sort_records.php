<?php
if(!isset($_GET['host']))
{
?>
	<script>
		alert("Connect to the server first."); 
		window.location.href="index.php";				
	</script>
<?php
}
else
{
	$host=$_GET['host'];
	$port=$_GET['port'];
}
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




<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('_id[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function toggleSelectAll(source)
{
	selectAllCheckBox=document.getElementById("selectAll");
	
	if((selectAllCheckBox.checked==true))
	{
		if(source.checked==false)
		{
			selectAllCheckBox.checked=false;
		}
	}
}


</script>




</head>
<body>
<header> <!--holds the site name or logo-->
<img src="images/mongo_logo.jpg" height=70px width=250px></img>


</header>



<div id=upperbar></div>



<!--css for table-->
<style style="text/css">

  	.idTab{
		width:100%; 
		border-collapse:collapse; 
	}
	.idTab td,th{ 
		padding:7px; border:#4e95f4 1px solid;
		
	}
	
	/* Define the default color for all the table rows */
	.idTab tr{
		background: #b8d1f3;
	}
	/* Define the hover highlight color for the table row */
/*    .idTab tr:hover {
	font-size:120%;
          background-color: #ffff99;
		
    }
*/
</style>
<!--end css-->















<div id="container">
<nav1> <!--Left hand column - if used for something other than navigation change its name-->


<?php

	$authentication=$_GET['authenticate'];
//	echo $authentication;

	if($authentication==0)
	{

		$connection=new Mongo($host.":".$port);

	/*	if($connection==NULL)
		{
		?>
			<script>
				alert("Connection to the server failed."); 
				window.location.href="index.php";				
			</script>
		<?php



		}
	*/
		$dbList=$connection->admin->command(array("listDatabases"=>1));


	/*	
		if($dbList['ok']==0)
		{
			echo "hello";
		}
	*/
	//	var_dump($dbList);

		?>

	
		<br>
		<form action="addDatabase.php">
		&nbsp;
		<input type="text" name="newDb" id="newDb" placeholder="Add New Database" style="height:30px; width:65%;" required="required" />
		<input type="Submit" value="Add" style="height:35px; width:22%; "/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		<input type=hidden name=authenticate value="<?php echo $authentication;?>">

		&nbsp;
		</form>
		<br>



		<div id='cssmenu'>
		<ul>
		   <li class='active'><a href='index1.php?host=<?php echo $host;?>&port=<?php echo $port;?>&authenticate=<?php echo $authentication; ?>'><span>Home</span></a></li>
		<?php

	
		foreach($dbList as $db1)
		  {
		    foreach($db1 as $db2)
		      {
			?>

		   <li class='has-sub' ><a href='#'><span><?php echo $db2['name'];?></span></a>
		      <ul>

	
			  <?php
			  $db=$connection->$db2['name'];
			  $list=$db->listCollections();

			  foreach($list as $collection)
			    {
			?>

		
	
			 <li><a href='index1.php?collection=<?php echo $collection->getName();?>&db=<?php echo $db;?>&host=<?php echo $host;?>&port=<?php echo $port;?>&authenticate=<?php echo $authentication; ?>'>
				<span><?php echo $collection->getName();?></span>
				</a></li>

			<?php
			}
			?>


		<li></li>
		<!--Text box for adding collection-->
		<li>
		<form action="addCollection.php">
		<input type="text" name="newCollection" id="newCollection" placeholder="Add New Collection" style="height:20px; width:70%;" required="required" />
		<input type=hidden name="dbname" value=<?php echo $db; ?> >
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		<input type=hidden name=authenticate value="<?php echo $authentication;?>">

		<input type="Submit" value="Add" style="height:30px; width:25%; "/>
		</form>
		</li>

			<li>
				<form action=dropDatabase.php>
				<input type=hidden name="db" value=<?php echo $db; ?> >
				<input type=submit value="Drop Database" style="width:100%; height:30px"/>
				<input type=hidden name=host value="<?php echo $host; ?>"/>
				<input type=hidden name=port value="<?php echo $port; ?>"/>
				<input type=hidden name=authenticate value="<?php echo $authentication;?>">

				</form>
			</li>

		      </ul>
		   </li>

		<?php
		      }
		  }

		?>

		</ul>


		</div><!--end css menu-->

<?php	
	}
	else
	{



			$username=$_GET['username'];
			$password=$_GET['password'];
			$database=$_GET['database'];
	

			if($database!="admin")
			{			

			echo "<br><br>";


			
				$connection = new Mongo($host.":".$port, array(
	    			'username' => $username,
	    			'password' => $password,
			    	'db'       => $database
				));			
						
				//var_dump($db);

			
		
	//			$connection=new Mongo($host.":".$port);
	
			
				$db=$connection->$database;
				$list=$db->listCollections();
			
	?>


			<div id='cssmenu'>
			<ul>
			   <li class='active'><a href='index1.php?host=<?php echo $host;?>&port=<?php echo $port;?>&username=<?php echo $username; ?>&password=<?php echo $password; ?>&database=<?php echo $database; ?>&authenticate=<?php echo $authentication;?>'><span>Home</span></a></li>
	
			   <li class='has-sub' ><a href='#'><span><?php echo $database;?></span></a>
			      <ul>

	
				  <?php
				  $db=$connection->$database;
				  $list=$db->listCollections();

				  foreach($list as $collection)
				    {
				?>

		
	
				 <li><a href='index1.php?collection=<?php echo $collection->getName();?>&db=<?php echo $db;?>&host=<?php echo $host;?>&port=<?php echo $port;?>&username=<?php echo $username; ?>&password=<?php echo $password; ?>&database=<?php echo $database; ?>&authenticate=<?php echo $authentication; ?>'>
					<span><?php echo $collection->getName();?></span>
					</a></li>

				<?php
				}
				?>


			<li></li>
			<!--Text box for adding collection-->
			<li>
			<form action="addCollection.php">
			<input type="text" name="newCollection" id="newCollection" placeholder="Add New Collection" style="height:20px; width:70%;" required="required" />
			<input type=hidden name="dbname" value=<?php echo $db; ?> >
			<input type=hidden name=host value="<?php echo $host; ?>"/>
			<input type=hidden name=port value="<?php echo $port; ?>"/>

			<?php
			if(isset($_GET['username']) and (strlen($_GET['username'])!=0))
			{
			?>

			<input type=hidden name=username value="<?php echo $username;?>">
			<input type=hidden name=password value="<?php echo $password;?>">
			<input type=hidden name=database value="<?php echo $database;?>">
			<?php
			}

			?>
			<input type=hidden name=authenticate value="<?php echo $authentication;?>">
			<input type="Submit" value="Add" style="height:30px; width:25%; "/>
			</form>
			</li>

				<li>
					<form action=dropDatabase.php>
					<input type=hidden name="db" value=<?php echo $db; ?> >
					<input type=submit value="Drop Database" style="width:100%; height:30px"/>
					<input type=hidden name=host value="<?php echo $host; ?>"/>
					<input type=hidden name=port value="<?php echo $port; ?>"/>

					<?php
					if(isset($_GET['username']) and (strlen($_GET['username'])!=0))
					{
					?>

					<input type=hidden name=username value="<?php echo $username;?>">
					<input type=hidden name=password value="<?php echo $password;?>">
					<input type=hidden name=database value="<?php echo $database;?>">
					<?php
					}

					?>
					<input type=hidden name=authenticate value="<?php echo $authentication;?>">
					</form>
				</li>

			      </ul>
			   </li>

			</ul>

			</div><!--end css menu-->



<?php


			}
			else
			{
			
				$connection = new Mongo($host.":".$port, array(
	    			'username' => $username,
	    			'password' => $password,
			    	'db'       => $database
				));			


		$dbList=$connection->admin->command(array("listDatabases"=>1));


	/*	
		if($dbList['ok']==0)
		{
			echo "hello";
		}
	*/
	//	var_dump($dbList);

		?>

	
		<br>
		<form action="addDatabase.php">
		&nbsp;
		<input type="text" name="newDb" id="newDb" placeholder="Add New Database" style="height:30px; width:65%;" required="required" />
		<input type="Submit" value="Add" style="height:35px; width:22%; "/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		<input type=hidden name=authenticate value="<?php echo $authentication;?>">

		<?php
		if(isset($_GET['username']) and (strlen($_GET['username'])!=0))
		{
		?>

		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
		}

		?>

		&nbsp;
		</form>
		<br>



		<div id='cssmenu'>
		<ul>
		   <li class='active'><a href='index1.php?host=<?php echo $host;?>&port=<?php echo $port;?>&username=<?php echo $username; ?>&password=<?php echo $password; ?>&database=<?php echo $database; ?>&authenticate=<?php echo $authentication; ?>'><span>Home</span></a></li>
		<?php

	
		foreach($dbList as $db1)
		  {
		    foreach($db1 as $db2)
		      {
			?>

		   <li class='has-sub' ><a href='#'><span><?php echo $db2['name'];?></span></a>
		      <ul>

	
			  <?php
			  $db=$connection->$db2['name'];
			  $list=$db->listCollections();

			  foreach($list as $collection)
			    {
			?>

		
	
			 <li><a href='index1.php?collection=<?php echo $collection->getName();?>&db=<?php echo $db;?>&host=<?php echo $host;?>&port=<?php echo $port;?>&username=<?php echo $username; ?>&password=<?php echo $password; ?>&database=<?php echo $database; ?>&authenticate=<?php echo $authentication; ?>'>
				<span><?php echo $collection->getName();?></span>
				</a></li>

			<?php
			}
			?>


		<li></li>
		<!--Text box for adding collection-->
		<li>
		<form action="addCollection.php">
		<input type="text" name="newCollection" id="newCollection" placeholder="Add New Collection" style="height:20px; width:70%;" required="required" />
		<input type=hidden name="dbname" value=<?php echo $db; ?> >
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		<?php
		if(isset($_GET['username']) and (strlen($_GET['username'])!=0))
		{
		?>

		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
		}

		?>

		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
		<input type="Submit" value="Add" style="height:30px; width:25%; "/>
		</form>
		</li>

			<li>
				<form action=dropDatabase.php>
				<input type=hidden name="db" value=<?php echo $db; ?> >
				<input type=submit value="Drop Database" style="width:100%; height:30px"/>
				<input type=hidden name=host value="<?php echo $host; ?>"/>
				<input type=hidden name=port value="<?php echo $port; ?>"/>

				<?php
				if(isset($_GET['username']) and (strlen($_GET['username'])!=0))
				{
				?>

				<input type=hidden name=username value="<?php echo $username;?>">
				<input type=hidden name=password value="<?php echo $password;?>">
				<input type=hidden name=database value="<?php echo $database;?>">
				<?php
				}

				?>
				<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
				</form>
			</li>

		      </ul>
		   </li>

		<?php
		      }
		  }

		?>

		</ul>

		</div><!--end css menu-->


<?php

	}
}
	?>



</nav1>

<section id="content"> <!--Right hand column-->





<!--Menu above the table-->

<!--Menu above the table-->


<div id="tabMenu1" align=right>
  <ul>
    <li><a href="index.php"><span>Logout</span></a></li>
    <li><a href="index.php"><span>About Us</span></a></li>
	<?php 

	if(isset($_GET["collection"]) && isset($_GET["db"]))
	{

$temp="userManagement.php?db=".$_GET['db']."&collection=".$_GET['collection']."&host=".$host."&port=".$port."&authenticate=".$authentication;

		if($authentication==1)
		{
			$temp=$temp.'&username='.$_GET['username'];
			$temp=$temp.'&password='.$_GET['password'];					
			$temp=$temp.'&database='.$_GET['database'];
		}


	?>
		<li><a href=<?php echo $temp;?> ><span>User Management</span></a></li>

	<?php
	}
	
	?>

  </ul>
</div>

<br><br>


<!--
<div id="tabMenu">
  <ul>
    <li><a href="#"><span>CSS Templates</span></a></li>
    <li><a href="#"><span>CSS Layouts</span></a></li>
    <li><a href="#"><span>CSS Books</span></a></li>
    <li><a href="#"><span>CSS Menus</span></a></li>
    <li><a href="#"><span>CSS Tutorials</span></a></li>
    <li><a href="#"><span>CSS Reference</span></a></li>
    <li><a rel="nofollow" target="_blank" href="#" title="explodingboy"><span>explodingboy</span></a></li>
  </ul>
</div>

<br><br><br>
-->



<!--<textarea rows="10" cols="100" name="message">Your text...</textarea>
<br>
<input type="submit" value="SEND" name="submit" />
<br>
-->
<?php



    function display_json_format($document){
        $json_format = "{";
        
        foreach ($document as $key=>$value){
           
            $json_format .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            
            if(!strcasecmp($key, "_id"))
                $json_format .= "\"$key\" : ObjectId(<font color=\"#D33301\">\"$value\"</font>),";    
            elseif(is_string($value))
                $json_format .= "\"$key\" : <font color=\"#D33301\">\"$value\"</font>,";
            elseif(is_array($value))
                $json_format .= "\"$key\" : <font color=\"#008200\">".display_json_format($value)."</font>,";
	    else		
                $json_format .= "\"$key\" : <font color=\"#008200\">$value</font>,";
           
        }
        
        $json_format = rtrim($json_format,",");
        $json_format .= "<br>}<br>";
        
        return trim($json_format);
    }




if(isset($_GET["collection"]) && isset($_GET["db"]))
	{

		$db=$_GET["db"];		
		$collection=$_GET["collection"];


		
		//echo "Database=".$db."<br>";
		//echo "Collection=".$collection."<br>";

		$dbConnect=$connection->$db;		


		/*code for pagenation*/

		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		if(isset($_GET['limit']))
		{
			if($_GET['limit']=="all")
			{
				$limit = 0;	
			}
			else
				$limit = $_GET['limit'];			
		}		
		else	
		{		
			$limit = 5;
		}
		
		$skip = ($page - 1) * $limit;
		$next = ($page + 1);
		$prev = ($page - 1);

		$totalRecords=$dbConnect-> $collection ->find()->count();
		

		echo "<font size=4><b>".$db." -> ".$collection."(".$totalRecords.")</b></font>";
		echo "<br><br>";

		?>




<!--Query text box-->

<style>
textarea {
  background-color:grey;
color:white;
font-size:15px;
  border: 1px solid #888;
	
}
$('textarea').autoResize(); 
</style>

		<?php
			$temp='';
			if(isset($_GET['display_key']))
			{
				$temp.="{},{";
				

			
//				foreach($_GET['display_key'] as $Dkey)

				$DkeyArray=$_GET['display_key'];

				for($i=0;$i<sizeof($DkeyArray)-1;$i++)
				{
					$temp.=$DkeyArray[$i].":1,";
				}
					$temp.=$DkeyArray[$i].":1";
				
				$temp.="}";
			}
		
		?>


		<form action=processQuery.php>

		Query: 

<!--                <textarea class="text_query" name="query" style="width:100%; height:75px;">
		<?php printf("\n");?>db.<?php echo $collection;?>.find().sort({<?php echo $_GET['sort_key']; ?>:<?php if($_GET['sortMethod']=="ascending") echo "1"; else echo "-1"; ?>});
		</textarea>
-->
                <textarea class="text_query" name="query" style="width:100%; height:75px;">
		<?php 

			printf("\n");?>db.<?php echo $collection;
		?>.find(<?php echo $temp; ?>).sort({<?php echo $_GET['sort_key']; ?>:<?php if($_GET['sortMethod']=="ascending") echo "1"; else echo "-1"; ?>})<?php if(isset($_GET['page']) && $skip!=0) echo ".skip(".$skip.")"?><?php if($limit!=0) echo ".limit(".$limit.")";?>;

		</textarea>
	
		<div align=right><input type=submit value=Submit></div>
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>

		<?php
		if($authentication==1)
		{
		?>

		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
		}

		?>

		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
		</form>







<!--keys to display-->
		<div style="text-align:center;">

    		<div style="display:inline-block;">

		<input type=button value="Select Keys to display" onclick="displayKeys()">
		</div>













<!--No of records to display-->


    		<div style="display:inline-block;">

	

		<form action=sort_records.php>
		To display:
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=sort_key value="<?php echo $_GET['sort_key']; ?>"/>
		<input type=hidden name=sortMethod value="<?php echo $_GET['sortMethod']; ?>"/>		
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		


		<?php
			if($authentication==1)
			{
		?>
		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">

		<?php
			}
		?>
		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
<!--		<input type=text name=limit value="<?php echo $limit; ?>" onchange="this.form.submit();" /> -->

		<select name=limit onchange="this.form.submit();">

	
		



		<option value=5 <?php if($limit==5) echo "selected=selected"; ?>>5</option>
		<option value=10 <?php if($limit==10) echo "selected=selected"; ?>>10</option>
		<option value=15 <?php if($limit==15) echo "selected=selected"; ?>>15</option>
		<option value=all <?php if($limit==0) echo "selected=selected"; ?>>All</option>

		</select>

	
		<?php
		if(isset($_GET['display_key']))
		{
			foreach($_GET['display_key'] as $Dkey)
			{
		
			?>
			<input type=hidden name=display_key[] value="<?php echo $Dkey; ?>"/>
			<?php
			}
		}
		?>

		</form>

		</div>



<!--Search box-->
		

		<div style="display:inline-block;">

		<form action="search_records.php">
		&nbsp;&nbsp;&nbsp;
		Search: <input type=text name=search_text placeholder="{key:value}" style="width:100px">		
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>

		<?php
		if(isset($_GET['page']))
		{
		?>
		<input type=hidden name=page value="<?php echo $page; ?>"/>
		
		<?php
		}
		if(isset($_GET['limit']))
		{
		?>		
		<input type=hidden name=limit value="<?php echo $limit; ?>"/>
		<?php
		}

		?>
		
		<?php
		if($authentication==1)
		{
		?>

		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
		}

		?>



		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">

		<input type="submit" value="Search">
			
		</form>

		
		</div>



		<input type=button value=Sort onclick="displaySort()" style="width:100px">  <!--Sort button-->


		</div>

<script>
function displaySort()
{
	//var temp=document.getElementById("sort_form").style.visibility="visible";
	var temp=document.getElementById("sort_form");

	if(temp.style.visibility=="hidden")
	{
		temp.style.visibility="visible";
	}
	else
	{
		temp.style.visibility="hidden";
	}


}


function displayKeys()
{
	//var temp=document.getElementById("sort_form").style.visibility="visible";
	var temp=document.getElementById("keysToDisplay");

	if(temp.style.visibility=="hidden")
	{
		temp.style.visibility="visible";
	}
	else
	{
		temp.style.visibility="hidden";
	}
}

</script>



<!--Sort-->


<?php


		$records=$dbConnect-> $collection ->find()->skip($skip)->limit($limit);


		$array = iterator_to_array($records);
	
		$keys = array();
		foreach ($array as $k=>$v) {
		foreach ($v as $a=>$b) {
			$keys[] = $a;
		}
		}
		$keys = array_values(array_unique($keys));
?>

<div style="text-align:center;">


<div id=keysToDisplay style="display:inline-block; visibility:hidden">

<form action=sort_records.php>

<select name=display_key[] multiple=multiple>

<?php
		foreach($keys as $k)
			{
				
				?>
				<option value=<?php echo $k;?> ><?php echo $k; ?> </option>
				<?php

			}


?>

</select>

<input type=submit value="Display">


<input type=hidden name=db value="<?php echo $db; ?>"/>
<input type=hidden name=collection value="<?php echo $collection; ?>"/>
<input type=hidden name=host value="<?php echo $host; ?>"/>
<input type=hidden name=port value="<?php echo $port; ?>"/>
<input type=hidden name=sort_key value="<?php echo $_GET['sort_key']; ?>"/>
<input type=hidden name=sortMethod value="<?php echo $_GET['sortMethod']; ?>"/>
<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
<?php
if($authentication==1)
{
?>

<input type=hidden name=username value="<?php echo $username;?>">
<input type=hidden name=password value="<?php echo $password;?>">
<input type=hidden name=database value="<?php echo $database;?>">
<?php
}

?>

</form>


</div>


<div id=sort_form style="display:inline-block; visibility:hidden" align=center>
<br>
<form action=sort_records.php>
<select name=sort_key>

<?php
		foreach($keys as $k)
			{
				
				?>
				<option value=<?php echo $k;?> ><?php echo $k; ?> </option>
				<?php

			}


?>

</select>
<select name=sortMethod>
<option value="none">Select Method</option>
<option value="ascending">Ascending</option>
<option value="descending">Descending</option>
</select>

<input type=hidden name=db value="<?php echo $db; ?>"/>
<input type=hidden name=collection value="<?php echo $collection; ?>"/>
<input type=hidden name=host value="<?php echo $host; ?>"/>
<input type=hidden name=port value="<?php echo $port; ?>"/>
<input type=hidden name=authenticate value="<?php echo $authentication; ?>">

<?php
if($authentication==1)
{
?>

<input type=hidden name=username value="<?php echo $username;?>">
<input type=hidden name=password value="<?php echo $password;?>">
<input type=hidden name=database value="<?php echo $database;?>">
<?php
}

?>

<input type=submit value="Sort" />



</form>

</div>

</div>







		<?php
	
		//echo "<br>";

//		$key="name";

		$last=ceil(($totalRecords/$limit));


		if(isset($_GET['display_key']))
		{

			$records=$dbConnect-> $collection ->find(array(),$_GET['display_key']);
		}
		else
		{
			$records=$dbConnect-> $collection ->find();		

		}


//		$records=$dbConnect-> $collection ->find();

//		$records=$records->sort(array($key=>-1));

		


		if(isset($_GET['sort_key']))
		{
			$sort_key=$_GET['sort_key'];
		}
		
		if(isset($_GET['sortMethod']))
		{
			if($_GET['sortMethod']=='ascending')
			{
				$sortMethodValue=1;
				$sortMethod=$_GET['sortMethod'];
			}
			else
			{
				$sortMethodValue=-1;			
				$sortMethod=$_GET['sortMethod'];
			}
		}


		if(isset($_GET['sortMethod']))
		{
			$records=$records->sort(array($sort_key=>$sortMethodValue));
		}



		$records=$records->skip($skip)->limit($limit);

		

//  		$records=$dbConnect-> $collection ->find();
		$total=$records->count();

		$doc_frame=$skip+1;	
		
		while ($document = $records->getNext())
	            {

	                $doc = display_json_format($document); 
			$format = json_encode($document);	

	?>
                       <fieldset>
                            <legend><?php echo "Document $doc_frame"; ?></legend>
<?php 
	$temp="edit_doc.php?id=".$document['_id']."&db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}


?>

                            <a href="<?php echo $temp; ?>">Edit</a>

<?php

	$temp="remove_doc.php?id=".$document['_id']."&db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}


?>
                            &nbsp;<a href="<?php echo $temp; ?>" onclick="return confirm('Are you sure, you want to delete document?')">Remove</a><br>
                            <?php echo "$doc"; ?>

                        </fieldset>

                    <br>

                
                <?php
                $doc_frame += 1;


			

		    }



/*		


		$array = iterator_to_array($records);
	
		$keys = array();
		foreach ($array as $k=>$v) {
		foreach ($v as $a=>$b) {
			$keys[] = $a;
		}
		}
		$keys = array_values(array_unique($keys));

*/
/*
		foreach($keys as $k)
			{
				echo $k;
				echo "<br>";
			}

		echo "<br><br>";

		foreach($records as $res)
		{
			foreach($keys as $k)
			{
				echo $k."=>";
				echo $res[$k]." ";
			}
			//echo $res["_id"];			
			//echo "<br>";			
			//print_r($res);	    
  			//echo "<br>";

			echo "<br><br>";

		}
*/
?>

<!--css for links in table-->

<style type="text/css">
A:link {text-decoration: none}
A:visited {text-decoration: none}
A:active {text-decoration: none}
A:hover {text-decoration: underline; color: red;}
</style>
<!--end css-->

	<form action="deleteDocument.php" method="get" id="deleteDocument">
<!--	<table border=2 width=100%" class=idTab>

	<?php 
		$cnt=(($page-1)*10)+1;
		//echo count($keys);
//	echo $cnt; echo $page;
	?>
		<tr>
	<?php	if(count($keys)!=0)
		{
	?>
		<th><input type="checkbox" onClick="toggle(this)" id="selectAll"/></th>
		<th>No.</th>

	<?php
		}
	?>
	 
	<?php
	
		foreach($keys as $k)
		{
	?>
			<th><?php echo $k ?></th>
		
	<?php	
		}	

	?>
	
		</tr>

		<?php
		foreach($records as $res)
		{
		?>			
			<tr>
			<?php
				echo '<td align=center><input type="checkbox" id="_id" name="_id[]" value="'.$res['_id'].'" onClick="toggleSelectAll(this)"/></td>';
			?>
			<td align=center><?php echo $cnt; $cnt++;?></td>
			
		<?php
			foreach($keys as $k)
			{

		?>
	<!--		<td align=center><a href="JavaScript:newPopup('showRecords.php?id=<?php echo $res[$keys[0]]?>&db=<?php echo $db?>&collection=<?php echo $collection?>');"><?php echo $res[$k]?></a></td>
		-->
	<!--		<td align=center>
				<a href="index1.php?id=<?php echo $res[$keys[0]];?>&db=<?php echo $db;?>&collection=<?php echo $collection;?>#join_form" id="join_pop"><?php echo $res[$k];?></a>
				</td>
	
			<?php
			}
			?>
			</tr>

		<?php		
		}
		?>
		
	</table>
	--><br>
	<div id=pageNo align=center>
<?php		
			
	/*Pagenation code displaying previous and next*/
	if($limit!=0)
	{
	if($page > 1){
	
	$temp='?collection='.$collection.'&db='.$db.'&page=1&limit='.$limit.'&sort_key='.$sort_key.'&sortMethod='.$sortMethod.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}


	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_first.ico" height=30px title="First"></img> </font></a>';


	$temp='?collection='.$collection.'&db='.$db.'&page=' . $prev . '&limit='.$limit.'&sort_key='.$sort_key.'&sortMethod='.$sortMethod.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo '<a href="'.$temp.'"><font size=5><img src="images/go_left.ico" height=30px title="Previous"></img></font></a>';
	

	if(($page * $limit < $total) && $limit!=0) {
	
	$temp='?collection='.$collection.'&db='.$db.'&page=' . $next . '&limit='.$limit.'&sort_key='.$sort_key.'&sortMethod='.$sortMethod.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';

	$temp='?collection='.$collection.'&db='.$db.'&page=' . $last . '&limit='.$limit.'&sort_key='.$sort_key.'&sortMethod='.$sortMethod.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font></a>';

	}
	else
	{
	
	echo '<font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font>';
	echo '<font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font>';

	}
	} else {
	

	if($page * $limit < $total) {
		
	echo '<font size=5><img src="images/go_first.ico" height=30px title="First"></img></font>';

	echo '<font size=5><img src="images/go_left.ico" height=30px title="Previous"></img></font>';


	$temp='?collection='.$collection.'&db='.$db.'&page=' . $next . '&limit='.$limit.'&sort_key='.$sort_key.'&sortMethod='.$sortMethod.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';
	}
	if($last>1)
	{
		$temp='?collection='.$collection.'&db='.$db.'&page=' . $last . '&limit='.$limit.'&sort_key='.$sort_key.'&sortMethod='.$sortMethod.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font></a>';
	}	
	}
	}
?>

	<input type=hidden name=db value="<?php echo $db; ?>"/>
	<input type=hidden name=collection value="<?php echo $collection; ?>"/>

	<?php
	if($total!=0)
	{

	?>




<!--Bottom menu appears only if table contains any records-->
<br><br>
	<div id="tabMenu">
	  <ul>
<!--	    <li><a href="#" onclick="document.getElementById('deleteDocument').submit();"><span>Delete Selected</span></a></li> -->
<!--	    <li><a href="index1.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>#insertRecord" id="join_pop"><span>Add New Document</span></a></li>
	<li><a href="deleteCollection.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>"><span>Delete Collection</span></a></li>-->

	<li><a href="add_doc.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>&host=<?php echo $host;?>&port=<?php echo $port;?>"><span>Add New Document</span></a></li>
	<li><a href="deleteCollection.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>&host=<?php echo $host; ?>&port=<?php echo $port; ?>"><span>Delete Collection</span></a></li>
	<li><a href="emptyCollection.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>&host=<?php echo $host;?>&port=<?php echo $port;?>"><span>Empty Collection</span></a></li>
	  </ul>	
	</div>
	<br><br>


	
	<?php 

	}
	else
	{
		echo "Empty Collection";

	?>
	<div id="tabMenu">
	  <ul>
		<li><a href="add_doc.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>&host=<?php echo $host;?>&port=<?php echo $port; ?>" ><span>Add New Document</span></a></li>
		<li><a href="deleteCollection.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>&host=<?php echo $host; ?>&port=<?php echo $port; ?>"><span>Delete Collection</span></a></li>
	        <!--<li><a href="add_doc?db=<?php echo $db;?>&collection=<?php echo $collection;?>#insertRecord" id="join_pop"><span>Add New Document</span></a></li>
		<li><a href="deleteCollection.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>"><span>Delete Collection</span></a></li>-->
		<li><a href="emptyCollection.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>&host=<?php echo $host;?>&port=<?php echo $port;?>"><span>Empty Collection</span></a></li>	

	  </ul>	
	</div>

	<?php
	}
	?>

	</form>




	</div>	
<?php
	}
?>

</section>
</div> <!--end container-->

<script>

function clearForm()
{
	//alert("hello");
	document.getElementById('newRecord').innerHTML="";


}

function addNewValuePair(id,db,collection)
{
	var formHeader="<form action=addNewValuePair.php><table>";
	var formFooter="</form></table>";
	var hiddenContents='';
	var formBody='';

	formBody+='<tr><td>Enter Key</td><td>:</td> <td><input type=text name=newKey placeholder="Key" required="required"></td></tr>';
	formBody+='<tr><td>Enter Value</td><td>:</td> <td><input type=text name=newValue placeholder="Value" required="required"></td></tr>';

	formBody+='<tr><td><input type=Submit value="Save"></td><td></td>';
	formBody+='<td><input type=button value="Cancel" onClick="clearForm()"></td></tr>';

	hiddenContents+='<input type="hidden" name=id value='+id+'>';
	hiddenContents+='<input type="hidden" name=db value='+db+'>';
	hiddenContents+='<input type="hidden" name=collection value='+collection+'>';

	
	document.getElementById('newRecord').innerHTML=(formHeader+formBody+hiddenContents+formFooter);
} 

function insertRecordClearForm()
{
	document.getElementById('insert_newKey').value="";
	document.getElementById('insert_newVal').value="";
}

</script>

<a href="#x" class="overlay" id="join_form"></a>
        <div class="popup">
	
		<?php 
			$id=$_GET['id'];
			$db=$_GET['db'];
			$collection=$_GET['collection'];						
			
			$records1=$dbConnect->$collection->findOne(array('_id'=> new MongoId($id)));

			echo "<br><br>";

			echo "localhost"."=>";
			echo $db."=>".$collection." ";
			echo "<br><br>";
		?>
		<center>	
<!--		<form name="editRecord" action="edit_record.php" method=post>-->
		
		<form action="update.php" method="get" id="display_doc">
		<table border=2 width=100%" class=idTab id="idTab">	
			<tr>
				<th>Key</th>
				<th>Value</th>
			</tr>

		<?php
			foreach($records1 as $key=>$val)
				{
		?>
					<tr>
						<td align=center><?php echo $key;?></td>
						<td align=center>
							<?php //php echo $val;


							if($key!="_id")
							{
								echo '<input type=text name='.$key.' value='.$val.' required="required">';
							}
							else
							{

								echo '<input type=hidden name='.$key.' value='.$val.' >';
								echo $val;
							}														
							?></td>


					</tr>
		<?php
				}
 		?>
		
		</table>
		<br>
		<input type="submit" name="button" value="Update"/>
		<input type="submit" name="button" value="delete"/>
		<?php echo '<input type="button" value="add new Value" onClick=addNewValuePair("'.$id.'","'.$db.'","'.$collection.'");>' ?>

		<?php echo '<input type="hidden" name=db value='.$db.'>' ?>
		<?php echo '<input type="hidden" name=collection value='.$collection.'>' ?>
		
		

		</form>
		

		<div id="newRecord"></div>

	

            <a class="close" href="?collection=<?php echo $collection ?>&db=<?php echo $db ?>&page=<?php echo $page?>#close"></a>
        </div>

<a href="#x" id="edit_record"></a>










<!--Adding new record-->


<a href="#x" class="overlay" id="insertRecord"></a>
        <div class="popup">
	

	<?php
		echo "<br><br><b>";	
		echo "localhost"."=>";
		echo $db."=>".$collection." ";
		echo "</b><br><br>";
	?>
	<form action=addNewRecord.php>
		<table>

		<tr>
			<td>Enter Key</td>
			<td>:</td>
			<td><input type=text name=newKey placeholder="Key" id="insert_newKey" required="required"></td>
		</tr>

		<tr>
			<td>Enter Value</td>
			<td>:</td>
			<td><input type=text name=newValue placeholder="Value" id="insert_newVal" required="required"></td>
		</tr>
		<tr></tr>
		<tr>
			<td><input type=Submit value="Save"></td>
			<td></td>
			<td><input type=button value="Clear" onClick="insertRecordClearForm()"></td>
		</tr>

		
	</table>
		<input type="hidden" name=db value= <?php echo $_GET[db] ?> >
		<input type="hidden" name=collection value= <?php echo $_GET[collection];?>>

	</form>

	

            <a class="close" href="?collection=<?php echo $collection ?>&db=<?php echo $db ?>&page=<?php echo $page?>#close"></a>
        </div>













<?php header("Location:#"); ?>
<br><br>
</body>
</html>
