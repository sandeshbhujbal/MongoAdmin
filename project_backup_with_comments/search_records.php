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
                $json_format .= "\"$key\" : <font color=\"#008200\">$value</font>,";
	    else		
                $json_format .= "\"$key\" : <font color=\"#008200\">$value</font>,";
           
        }
        
        $json_format = rtrim($json_format,",");
        $json_format .= "<br>}<br>";
        
        return trim($json_format);
    }




function validate_format($qry){
        $qry = trim($qry);
        $open_bracket = $qry[0];
        $len = strlen($qry);
        $close_bracket = $qry[$len-1];
      
        if($open_bracket != '{' or $close_bracket != '}')
            return 0;
                    
        $format = ltrim($qry,'{');
        $format = rtrim($format,'}');
        
        $fields = explode(',',$format);
         foreach($fields as $value){
             $v = explode(':',$value);
            $pattern = '[0-9]';
            $v[1] = trim($v[1]);            
            /* check for other tha integer values */
            if(!@ereg($pattern, $v[1])){
                if(!@ereg('^"',$v[1]) || !@ereg('"$',$v[1]))
                    return 0;
            }
            else{/* integer value with quotes */
                if(@ereg('^"',$v[1]) && !@ereg('"$',$v[1]))
                    return 0;
                elseif(!@ereg('^"',$v[1]) && @ereg('"$',$v[1]))
                    return 0;
                
            }
            
            /* check for key */
            $v[0] = trim($v[0]);
            if(!@ereg($pattern, $v[0])){
                if(!@ereg('^"',$v[0]) || !@ereg('"$',$v[0]))
                return 0;
            }
        }
         
        return 1;
    }








//$search_key=$_GET['search_key'];;
//$search_value=$_GET['search_value'];;

//echo $search_key;
//echo $search_value;


$db=$_GET['db'];
$collection=$_GET['collection'];

//$searchArray=array($search_key=>$search_value);
//$searchArray=array(age=>45);
//print_r($searchArray);

$data = $_GET['search_text']; 

if(!validate_format($data))
{
echo "Search text is not in valid json format.";

$link="index1.php?collection=".$collection."&db=".$db."&host=".$host."&port=".$port."&authenticate=".$authentication;

	if($authentication==1)
	{
		$link=$link.'&username='.$_GET['username'];
		$link=$link.'&password='.$_GET['password'];					
		$link=$link.'&database='.$_GET['database'];
	}



//$link="index1.php?collection=".$collection."&db=".$db."&host=".$host."&port=".$port."&database=".$database."&username=".$username."&password=".$password."&authenticate=".$authentication;

if(isset($_GET['page']))
{
	$link=$link."&page=".$_GET['page'];
}
if(isset($_GET['limit']))
{
	$link=$link."&limit=".$_GET['limit'];
}


echo "<br><a href=".$link.">Go Back</a>";

}


$dbConnect=$connection->$db;

//$records=$dbConnect-> $collection ->find($searchArray);	




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




		
		//$cursor = $collection->find(json_decode($data));
		
//		$totalRecords=$dbConnect-> $collection ->find($searchArray)->count();
		$totalRecords=$dbConnect-> $collection ->find(json_decode($data))->count();

		
		
	

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

		<form action=processQuery.php>

		Query: 
                <textarea class="text_query" name="query" style="width:100%; height:75px;">
		<?php printf("\n");?>db.<?php echo $collection;?>.find(<?php echo $_GET['search_text']?>);
		</textarea>
		<div align=right><input type=submit value=Submit></div>
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


		</form>


<!--No of records to display-->

		<div style="text-align:center;">

		<form action=search_records.php>
		To display:
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=search_text value='<?php echo $_GET['search_text']; ?>'/>		
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



<!--		<input type=text name=limit value="<?php echo $limit; ?>" onchange="this.form.submit();" /> -->

		<select name=limit onchange="this.form.submit();">

		
		



		<option value=5 <?php if($limit==5) echo "selected=selected"; ?>>5</option>
		<option value=10 <?php if($limit==10) echo "selected=selected"; ?>>10</option>
		<option value=15 <?php if($limit==15) echo "selected=selected"; ?>>15</option>
		<option value=all <?php if($limit==0) echo "selected=selected"; ?>>All</option>

		</select>


		</form>

		</div>

<br>



<?php
	if($totalRecords==0)
	{
		echo "<br><br><br><br><br><br>";
		echo "<div align=center>";

		echo "No record Found";

		echo "</div>";
	}

?>




<?php
		$last=ceil(($totalRecords/$limit));

		//$totalRecords=$dbConnect-> $collection ->find(json_decode($data))->count();
//		$records=$dbConnect-> $collection ->find($searchArray)->skip($skip)->limit($limit);
//  		$records=$dbConnect-> $collection ->find();

		$records=$dbConnect-> $collection ->find(json_decode($data))->skip($skip)->limit($limit);


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


?>
















	<form action="deleteDocument.php" method="get" id="deleteDocument">
	<br>
	<div id=pageNo align=center>
<?php		
			
	/*Pagenation code displaying previous and next*/
	if($limit!=0)
	{
	if($page > 1){
	
	$temp='?collection='.$collection.'&db='.$db.'&page=1&limit='.$limit.'&host='.$host.'&port='.$port.'&search_text='.$data.'&authenticate='.$authentication;

	$temp1="&search_text=".$_GET['search_text'];

	$temp=$temp.$temp1;


	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href='.$temp.'><font size=5><img src="images/go_first.ico" height=30px title="First"></img> </font></a>';

	$temp='?collection='.$collection.'&db='.$db.'&page=' . $prev . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	$temp1="&search_text=".$_GET['search_text'];

	$temp=$temp.$temp1;


	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo '<a href='.$temp.'><font size=5><img src="images/go_left.ico" height=30px title="Previous"></img></font></a>';
	

	if(($page * $limit < $total) && $limit!=0) {
	
	$temp='?collection='.$collection.'&db='.$db.'&page=' . $next . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	$temp1="&search_text=".$_GET['search_text'];

	$temp=$temp.$temp1;

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href='.$temp.'><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';

	$temp='?collection='.$collection.'&db='.$db.'&page=' . $last . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

	$temp1="&search_text=".$_GET['search_text'];

	$temp=$temp.$temp1;

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	echo ' <a href='.$temp.'><font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font></a>';

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

	$temp1="&search_text=".$_GET['search_text'];

	$temp=$temp.$temp1;

	if($authentication==1)
	{
		$temp=$temp.'&username='.$_GET['username'];
		$temp=$temp.'&password='.$_GET['password'];					
		$temp=$temp.'&database='.$_GET['database'];
	}

	//echo $temp;
	echo ' <a href='.$temp.'><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';
	}
	if($last>1)
	{
		$temp='?collection='.$collection.'&db='.$db.'&page=' . $last . '&limit='.$limit.'&host='.$host.'&port='.$port.'&authenticate='.$authentication;


		$temp1="&search_text=".$_GET['search_text'];

		$temp=$temp.$temp1;

		if($authentication==1)
		{
			$temp=$temp.'&username='.$_GET['username'];
			$temp=$temp.'&password='.$_GET['password'];					
			$temp=$temp.'&database='.$_GET['database'];
		}
	
		echo ' <a href='.$temp.'><font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font></a>';
	}	

	}
	}
?>

	<input type=hidden name=db value="<?php echo $db; ?>"/>
	<input type=hidden name=collection value="<?php echo $collection; ?>"/>



	</form>





</section>





<!--<?php header("Location:#"); ?>-->
<br><br>
</body>
</html>
