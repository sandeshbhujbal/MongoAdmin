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



			$username=$_SESSION['username'];
			$password=$_SESSION['password'];
			$database=$_SESSION['database'];
	

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
			   <li class='active'><a href='index1.php?host=<?php echo $host;?>&port=<?php echo $port;?>&authenticate=<?php echo $authentication;?>'><span>Home</span></a></li>
	
			   <li class='has-sub' ><a href='#'><span><?php echo $database;?></span></a>
			      <ul>

	
				  <?php
				  $db=$connection->$database;
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

			<?php
/*			if(isset($_SESSION['username']) and (strlen($_SESSION['username'])!=0))
			{
			?>

			<input type=hidden name=username value="<?php echo $username;?>">
			<input type=hidden name=password value="<?php echo $password;?>">
			<input type=hidden name=database value="<?php echo $database;?>">
			<?php
			}
*/
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
/*					if(isset($_SESSION['username']) and (strlen($_SESSION['username'])!=0))
					{
					?>

					<input type=hidden name=username value="<?php echo $username;?>">
					<input type=hidden name=password value="<?php echo $password;?>">
					<input type=hidden name=database value="<?php echo $database;?>">
					<?php
					}
*/
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
/*		if(isset($_SESSION['username']) and (strlen($_SESSION['username'])!=0))
		{
		?>

		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
		}
*/
		?>

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
		<?php
/*		if(isset($_SESSION['username']) and (strlen($_SESSION['username'])!=0))
		{
		?>

		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
		}
*/
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
/*				if(isset($_SESSION['username']) and (strlen($_SESSION['username'])!=0))
				{
				?>

				<input type=hidden name=username value="<?php echo $username;?>">
				<input type=hidden name=password value="<?php echo $password;?>">
				<input type=hidden name=database value="<?php echo $database;?>">
				<?php
				}

*/				?>
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
                $json_format .= "\"$key\" : <font color=\"#008200\">$value</font>,";
	    else		
                $json_format .= "\"$key\" : <font color=\"#008200\">$value</font>,";
           
        }
        
        $json_format = rtrim($json_format,",");
        $json_format .= "<br>}<br>";
        
        return trim($json_format);
    }

function display_format($document,$level)
{
        print("\n");
	for($i=0;$i<$level;$i++)
	{
		printf("\t");		
	}
        print("{");

        $size = sizeof($document);
        $cnt = 0;
	
        foreach ($document as $key=>$value)
	{
            if(strcasecmp($key, "_id"))
		{
	                if($cnt == $size-1)
			{
				if(is_string($value))
				{
					printf("\n");
					for($i=0;$i<$level;$i++)
						{
							printf("\t");		
						}

                		    printf("\"%s\" : \"%s\"",$key,$value);
				}
               			else
				{
					printf("\n");
					for($i=0;$i<$level;$i++)
						{
							printf("\t");		
						}

                    			printf("\"%s\" : %d",$key,$value);
				}
               		}
            		else
			{
				if(is_array($value))
				{

					echo "\"".$key."\"".":";
					display_format($value,$level+1);
					echo ",";
					//printf("\n\t\"%s\" : \"%s\",",$key,display_format($value));
					
				}		     
		               elseif(is_string($value))
				{
					printf("\n");
				for($i=0;$i<$level;$i++)
					{
						printf("\t");		
					}
			            printf("\"%s\" : \"%s\",",$key,$value);
				}
		               else
				{
					printf("\n");
		                    printf("\"%s\" : %d,",$key,$value);	
				}
			} 
		}
            $cnt += 1;   
        }

        printf("\n");
	for($i=0;$i<$level;$i++)
	{
		printf("\t");		
	}
        printf("}");
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


	$submit='';
	$action='';

	if(isset($_GET['id']))	
	{
		$id = new MongoId($_GET['id']);
		setcookie('objectid',$id);
		$db=$_GET['db'];
		$collection=$_GET['collection'];
		$dbconnect=$connection->$db;
	        $data = $dbconnect->$collection->findOne(array('_id'=>$id));
//		print_r($data);		
	}

	if(isset($_GET['submit']) && $_GET['submit']==='save')
	{

		$action='update';
	}
	elseif(isset($_GET['submit']) && $_GET['submit']==='cancle')
	{
		$action='cancel';
	}
	

	switch($action)
	{

		case 'update':
			$new_doc = $_GET['query'];
			if(isset($new_doc)){
				
//				echo $new_doc;
				$new_doc_array = json_decode($new_doc);
				if(is_null($new_doc_array))
				{
	$temp="edit_doc.php?id=".$id."&db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;
		
/*		if($authentication==1)
		{
			$temp=$temp.'&username='.$_SESSION['username'];
			$temp=$temp.'&password='.$_SESSION['password'];					
			$temp=$temp.'&database='.$_SESSION['database'];
		}
*/

		?>	

<script>
alert("Invalid json format."); 
window.location.href="<?php echo $temp; ?>";				
</script>


		<?php
		
				}
				//print_r($new_doc_array);
					
				$objectid = new MongoId($_GET['id']);

				$dbconnect=$connection->$_GET['db'];
				$collection=$_GET['collection'];
				$dbconnect->$collection->update(array('_id'=>$objectid), $new_doc_array);
				echo "Document Updated Successfully.<br>";
				
				$temp="index1.php?collection=".$_GET['collection']."&db=".$_GET['db']."&host=".$host."&port=".$port."&authenticate=".$authentication;
		
/*			if($authentication==1)
			{
				$temp=$temp.'&username='.$_SESSION['username'];
				$temp=$temp.'&password='.$_SESSION['password'];					
				$temp=$temp.'&database='.$_SESSION['database'];
			}
*/

				echo "<a href=".$temp.">Go Back</>";					


		
			}
		case 'cancle'://header('location:index1.php?host='.$host.'&port='.$port);
			exit;
					
		default:
			break;



	}


?>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <br />            
                <textarea class="text_edit" name="query" style="width:100%; height:500px;">
                    <?php display_format($data,0);
                    ?>
                </textarea> 
                <section class="text">
		    <input type=hidden name=id value=<?php echo $id; ?> >
		    <input type=hidden name=db value=<?php echo $db; ?> >
	            <input type=hidden name=collection value=<?php echo $collection; ?> >
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>

		<input type=hidden name=authenticate value="<?php echo $authentication; ?>">
		<?php
/*			if($authentication==1)
			{
		?>
		<input type=hidden name=username value="<?php echo $username;?>">
		<input type=hidden name=password value="<?php echo $password;?>">
		<input type=hidden name=database value="<?php echo $database;?>">
		<?php
			}
*/
		?>
		

			
                <input type="submit" name="submit" value="save">

<?php 

$temp="index1.php?db=".$db."&collection=".$collection."&host=".$host."&port=".$port."&authenticate=".$authentication;

/*	if($authentication==1)
	{
		$temp=$temp.'&username='.$_SESSION['username'];
		$temp=$temp.'&password='.$_SESSION['password'];					
		$temp=$temp.'&database='.$_SESSION['database'];
	}
*/


?>		 
		<a href="<?php echo $temp; ?>"><input type="button" name="submit" value="cancle"></a>                   

                </section>
            </section>



<!--<?php header("Location:#"); ?>-->

</body>
</html>
