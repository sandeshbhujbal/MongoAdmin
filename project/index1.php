<?php
session_start();

if(!isset($_GET['host']))
{

	session_destroy();
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

	if($authentication==0)
	{
		try
		{
			$connection=new Mongo($host.":".$port);
		}
		catch (MongoConnectionException $e) 
		{
			?>
			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");

			window.location.href="index.php";
			</script>
			<?php
			
		}
		catch (MongoException $e)
		{
			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}
			$dbList=$connection->admin->command(array("listDatabases"=>1));

			if($dbList['ok']==0)
			{

			?>
				<script>
				alert("failed to connect to MongoDB <?php echo $dbList['errmsg'];?>");
				window.location.href="index.php";
				</script>
			<?php
			}
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

			try
			{
			  $db=$connection->$db2['name'];
			  $list=$db->listCollections();
			}
			catch (MongoConnectionException $e) 
			{

				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";
				</script>
				<?php
			}
			catch (MongoException $e)
			{
				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";
				</script>
				<?php
			}
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


			$username=$_SESSION['username'];
			$password=$_SESSION['password'];
			$database=$_SESSION['database'];

			if($database!="admin")
			{			

			echo "<br><br>";


			try
			{
				$connection = new Mongo($host.":".$port, array(
	    			'username' => $username,
	    			'password' => $password,
			    	'db'       => $database
				));			
						
			
				$db=$connection->$database;
				$list=$db->listCollections();
			}
			catch (MongoConnectionException $e) 
			{

				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";				
				</script>
				<?php
			
			}
			catch (MongoException $e)
			{
				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";
				</script>
				<?php
			}
	?>
			<div id='cssmenu'>
			<ul>
			   <li class='active'><a href='index1.php?host=<?php echo $host;?>&port=<?php echo $port;?>&authenticate=<?php echo $authentication;?>'><span>Home</span></a></li>
	
			   <li class='has-sub' ><a href='#'><span><?php echo $database;?></span></a>
			      <ul>

				  <?php

				try
				{
				  $db=$connection->$database;
				  $list=$db->listCollections();
				}
				catch (MongoConnectionException $e) 
				{

					?>
					<script>
					alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
					window.location.href="index.php";								
					</script>
					<?php
				}
				catch (MongoException $e)
				{
					?>

					<script>
					alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
					window.location.href="index.php";
					</script>
					<?php
				}
		
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

			</ul>

			</div><!--end css menu-->
<?php
			}
			else
			{			
			try
			{
				$connection = new Mongo($host.":".$port, array(
	    			'username' => $username,
	    			'password' => $password,
			    	'db'       => $database
				));			

			$dbList=$connection->admin->command(array("listDatabases"=>1));

			}
			catch (MongoConnectionException $e) 
			{

				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";
				</script>
				<?php

			}
			catch (MongoException $e)
			{
				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";
				</script>
				<?php
			}

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

			try
			{
			  $db=$connection->$db2['name'];
			  $list=$db->listCollections();
			}
			catch (MongoConnectionException $e) 
			{

				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");				
				window.location.href="index.php";
				</script>
				<?php
			
			}
			catch (MongoException $e)
			{
				?>

				<script>
				alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
				window.location.href="index.php";
				</script>
				<?php
			}

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
<div align=right>
<u>hello

<?php

if(isset($_SESSION['username']))
{
echo " ".$_SESSION['username'];
}
else
{
echo "Guest";
}


?>
</u>
</div>
<br>
<div id="tabMenu1" align=right>
  <ul>
    <li><a href="Logout.php"><span>Logout</span></a></li>
    <li><a href="aboutus.php"><span>About Us</span></a></li>

	<?php 

	if(isset($_GET["collection"]) && isset($_GET["db"]))
	{

$temp="userManagement.php?db=".$_GET['db']."&collection=".$_GET['collection']."&host=".$host."&port=".$port."&authenticate=".$authentication;

	?>
		<li><a href=<?php echo $temp;?> ><span>User Management</span></a></li>

	<?php
	}
	
	?>

  </ul>
</div>

<br><br>


<!--Menu above the table-->

<?php

    function display_json_format($document,$level){

    $json_format = "{";
        
        foreach ($document as $key=>$value){
           
            $json_format .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
	for($i=0;$i<$level;$i++)
	{
		$json_format .= "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;";		
	}
	
            
            if(!strcasecmp($key, "_id"))
                $json_format .= "\"$key\" : ObjectId(<font color=\"#D33301\">\"$value\"</font>),";    
            elseif(is_string($value))
                $json_format .= "\"$key\" : <font color=\"#D33301\">\"$value\"</font>,";
            elseif(is_array($value))
                $json_format .= "\"$key\" : <font color=\"#008200\">".display_json_format($value,$level+1)."</font>,";
	    else		
                $json_format .= "\"$key\" : <font color=\"#008200\">$value</font>,";
           
        }
        
        $json_format = rtrim($json_format,",");
        $json_format .= "<br>";


	for($i=0;$i<$level;$i++)
	{
		$json_format .= "&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;";		
	}

	$json_format .= "}";
        
        return trim($json_format);
    }




if(isset($_GET["collection"]) && isset($_GET["db"]))
	{

		$db=$_GET["db"];		
		$collection=$_GET["collection"];
		
		try
		{
			$dbConnect=$connection->$db;		
		}
		catch (MongoConnectionException $e) 
		{

			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
			
		}
		catch (MongoException $e)
		{
			?>
			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}

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


		try
		{
		$totalRecords=$dbConnect-> $collection ->find()->count();
		}
		catch (MongoConnectionException $e) 
		{

			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}
		catch (MongoException $e)
		{
			?>
			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}

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

                <textarea class="text_query" name="query" style="width:100%; height:75px;">
		<?php 

			printf("\n");?>db.<?php echo $collection;
		?>.find(<?php echo $temp; ?>)<?php if(isset($_GET['page']) && $skip!=0) echo ".skip(".$skip.")"?><?php if($limit!=0) echo ".limit(".$limit.")";?>;

		</textarea>

		<div align=right><input type=submit value=Submit></div>
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">

		</form>

<!--keys to display-->
		<div style="text-align:center;">

    		<div style="display:inline-block;">

		<input type=button value="Select Keys to display" onclick="displayKeys()">
		</div>
	
<!--No of records to display-->

    		<div style="display:inline-block;">

		<form action=index1.php>
		To display:
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">	

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
		Search: <input type=text name=search_text placeholder="{key:value}" style="width:100px" required="required">		
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
		
		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
		<input type="submit" value="Search">
			
		</form>

		</div>

		<input type=button value=Sort onclick="displaySort()" style="width:100px">  <!--Sort button-->

		</div>

<script>
function displaySort()
{
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

<?php

		try
		{
		$records=$dbConnect-> $collection ->find()->skip($skip)->limit($limit);
		}
		catch (MongoConnectionException $e) 
		{

			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}
		catch (MongoException $e)
		{
			?>
			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}
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

<form action=index1.php>

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
<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
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

<input type=submit value="Sort" />

</form>

</div>

</div>
		<?php

		$last=ceil(($totalRecords/$limit));

		try
		{
			if(isset($_GET['display_key']))
			{

				$records=$dbConnect-> $collection ->find(array(),$_GET['display_key'])->skip($skip)->limit($limit);
			}
			else
			{
				$records=$dbConnect-> $collection ->find()->skip($skip)->limit($limit);		

			}
		$total=$records->count();
		}
		catch (MongoConnectionException $e) 
		{

			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";				
			</script>
			<?php
		}
		catch (MongoException $e)
		{
			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}
		
		$doc_frame=$skip+1;	
		
		while ($document = $records->getNext())
	            {

	                $doc = display_json_format($document,0); 
			$format = json_encode($document);	

	?>

                        <fieldset>
                            <legend><?php echo "Document $doc_frame"; ?></legend>
<?php 
	$temp="edit_doc.php?id=".$document['_id']."&db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

?>

                            <a href="<?php echo $temp; ?>">Edit</a>

<?php

	$temp="remove_doc.php?id=".$document['_id']."&db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

?>
                            &nbsp;<a href="<?php echo $temp; ?>" onclick="return confirm('Are you sure, you want to delete document?')">Remove</a><br>
                            <?php echo "$doc"; ?>

                        </fieldset>
                    <br>
                
                <?php
                $doc_frame += 1;
		    }
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
	<br>
	<div id=pageNo align=center>
<?php		
			
	/*Pagenation code displaying previous and next*/
	if($limit!=0)
	{
	if($page > 1){
	
	$temp='?collection='.$collection.'&db='.$db.'&page=1&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;


	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_first.ico" height=30px title="First"></img> </font></a>';		

	$temp='?collection='.$collection.'&db='.$db.'&page=' . $prev . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	echo '<a href="'.$temp.'"><font size=5><img src="images/go_left.ico" height=30px title="Previous"></img></font></a>';

	if(($page * $limit < $total) && $limit!=0) {

	$temp='?collection='.$collection.'&db='.$db.'&page=' . $next . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';

	$temp='?collection='.$collection.'&db='.$db.'&page=' . $last . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
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


	$temp='?collection='.$collection.'&db='.$db.'&page=' . $next . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	if(isset($_GET['display_key']))
	{
		foreach($_GET['display_key'] as $key)
		{
			$temp=$temp.'&display_key[]='.$key;
		}
	}

	echo ' <a href="'.$temp.'"><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';

	}
	if($last>1)
	{
		$temp='?collection='.$collection.'&db='.$db.'&page=' . $last . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;
		
		if(isset($_GET['display_key']))
			{
				foreach($_GET['display_key'] as $key)
				{
					$temp=$temp.'&display_key[]='.$key;
				}
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

	<div id="tabMenu">
	  <ul>

	<?php 
	$temp="add_doc.php?db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

	?>

	<li><a href=<?php echo $temp;?>><span>Add New Document</span></a></li>

	<?php

	$temp="deleteCollection.php?db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;
		
	?>

	<li><a href=<?php echo $temp; ?>><span>Delete Collection</span></a></li>

	<?php 
	$temp="emptyCollection.php?db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

	?>
	<li><a href=<?php echo $temp; ?>><span>Empty Collection</span></a></li>
	  </ul>	
	</div>
	<br><br>
	
	<?php 

	}
	else
	{
		echo "Empty Collection";
		echo "<br><br><br>";

	?>
	<div id="tabMenu">
	  <ul>
	<?php 
		$temp="add_doc.php?db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

	?>
		<li><a href=<?php echo $temp; ?> ><span>Add New Document</span></a></li>

	<?php 
		$temp="deleteCollection.php?db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

	?>
		<li><a href=<?php echo $temp;?> ><span>Delete Collection</span></a></li>

	  </ul>	
	</div>

	<?php
	}
	?>

	</form>

<br>
	</div>	
<?php
	}
	else
	{

		echo "<b><font size=5>Server Status: </font></b>";
		echo "<br><br><br>";
		try
		{		
			if(isset($_SESSION['database']) and strlen($_SESSION['database'])!=0)
			{
			$dbConnect=$connection->$_SESSION['database'];
			}
			else
			{
			$dbConnect=$connection->admin;
			}
			$mongodb_info = $dbConnect->command(array('serverStatus'=>true));
		}
		catch (MongoConnectionException $e) 
		{

			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php
		}
		catch (MongoException $e)
		{
			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location.href="index.php";
			</script>
			<?php			
		}

		?>
		<center>
<style>


table.serverinfo {
	font-family: verdana,arial,sans-serif;
	font-size:20px;
	color:#333333;
	border-width: 1px;
	border-color: #999999;
	border-collapse: collapse;
	width:100%;

}
table.serverinfo tr {
	background:#b5cfd2 url('images/cell_blue.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;
	height:40px;
}
table.serverinfo td {
	background:#dcddc0 url('images/cell_grey.jpg');
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #999999;

}

</style>

		<table border=1 id="serverinfo" class="serverinfo">	

		<?php
		foreach($mongodb_info as $k=>$v)
		{
				
			if(!is_array($v) and !is_bool($v))
			{	
				echo "<tr>";				
				echo "<td>";
						
				echo "<b>".$k."</b>";	
				echo "</td>";

				echo "<td>";
						
				if(is_object($v))
				{
					ini_alter('date.timezone','Asia/Calcutta');
					echo date('Y-M-d h:i:s', $v->sec); 
				}
				if($v===true)
				{
					echo "true";
	
				}
				
				if($v===false)
				{
					echo "false";
				}
			
				if(is_float($v) and ($k!="ok"))
				{
					
					echo gmdate("H:i:s", $v);
				}
				else
				{
					echo $v;

				}

				echo "</td>";

				echo "</tr>";
			
			}

		}
		

		?>

		</table>
		</center>

	<?php	

	}
?>

</section>
</div> <!--end container-->

<script>

function clearForm()
{

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

<!--<?php header("Location:#"); ?>-->
<br><br>
</body>
</html>
