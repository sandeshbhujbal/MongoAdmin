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
<br>
<form action="addDatabase.php">
&nbsp;
<input type="text" name="newDb" id="newDb" placeholder="Add New Database" style="height:30px; width:65%;" required="required" />
<input type="Submit" value="Add" style="height:35px; width:22%; "/>
<input type=hidden name=host value="<?php echo $host; ?>"/>
<input type=hidden name=port value="<?php echo $port; ?>"/>

&nbsp;
</form>
<br>

<?php

$connection=new Mongo($host.":".$port);



/*
if($connection==NULL)
{
?>
	<script>
		alert("Connection to the server failed."); 
		window.location.href="index.php";				
	</script>
<?php



}*/
$dbList=$connection->admin->command(array("listDatabases"=>1));

?>


<div id='cssmenu'>
<ul>
   <li class='active'><a href='index1.php?host=<?php echo $host;?>&port=<?php echo $port;?>'><span>Home</span></a></li>
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

		
	
         <li><a href='index1.php?collection=<?php echo $collection->getName();?>&db=<?php echo $db;?>&host=<?php echo $host;?>&port=<?php echo $port;?>'>
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

<input type="Submit" value="Add" style="height:30px; width:25%; "/>
</form>
</li>

	<li>
		<form action=dropDatabase.php>
		<input type=hidden name="db" value=<?php echo $db; ?> >
		<input type=submit value="Drop Database" style="width:100%; height:30px"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>

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

</nav1>

<section id="content"> <!--Right hand column-->




<!--Menu above the table-->


<div id="tabMenu1" align=right>
  <ul>
    <li><a href="index.php"><span>Logout</span></a></li>
    <li><a href="index.php"><span>About Us</span></a></li>
  </ul>
</div>

<br><br>




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







function getArray($stringArray)
{

//echo "in function"."<br><br><br>";
//echo $stringArray;

$pos1=strpos($stringArray,"{");
//echo "<br>";
$pos2=strrpos($stringArray,"}");
//echo "<br>";

$stringArray=substr($stringArray,$pos1+1,$pos2-$pos1-1);

//echo $stringArray;
//echo "<br>";

$keyValueArray=explode(",",$stringArray);

//print_r($keyValueArray);

echo "<br><br>";

$keys=array();
$values=array();


for($i=0;$i<sizeof($keyValueArray);$i++)
{
	$keyValue=explode(":",$keyValueArray[$i],2);

	$keys[]=$keyValue[0];


	if(strpos($keyValue[1],"{")!==false)
	{
		$values[]=getArray($keyValue[1]);
	}
	else
	{
		if(strpos($keyValue[1],".")!==false)
		{
			if(is_numeric($keyValue[1]))
			{
				$values[]=(float)$keyValue[1];
				
			}
			else
			{
				$values[]=$keyValue[1];
			}
		}
		elseif(is_numeric($keyValue[1]))
		{
			$values[]=(int)$keyValue[1];
		}
		else
		{
			$values[]=$keyValue[1];
		}
	}



}

echo "<br><br>";

//echo "<br>keys: ";
//print_r($keys);

//echo "<br>values: ";
//print_r($values);
/*
foreach($values as $v)
{
echo gettype($v);
echo "<br>";
}
*/
$newArray=array_combine($keys,$values);

//echo "<br>new array: ";
//print_r($newArray);

return $newArray;
}







    function display_json_format($document,$level){
//	echo $level;    


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


	$query=$_GET['query'];
//	echo $query;





		$db=$_GET["db"];		
		$collection=$_GET["collection"];


		
		//echo "Database=".$db."<br>";
		//echo "Collection=".$collection."<br>";

		$dbConnect=$connection->$db;		





		$query=str_replace("\"","",$query);

		$temp=explode(".",$query);

		//print_r($temp);

		$collection=$temp[1];

	$records='';


if(strpos($query,"find")!==false)
{
	$pos1=strpos($query,"find");

//	echo "<br><br>";
	$pos2=strpos($query,")");

	$condition=substr($query,$pos1,$pos2-$pos1+1);


	if((($pos1+strlen("find("))-$pos2)!=0) //to check whether find condition is empty
	{

		$conditionAsArray=getArray($condition);

		//print_r($conditionAsArray);

		$records=$dbConnect->$collection->find($conditionAsArray);
	}
	else
	{
		$records=$dbConnect->$collection->find();
	}



//...........................sort............................................


	if(strpos($query,"sort")!==false)
	{
	$pos1=strpos($query,"sort");
//	echo "<br>";
	$query1=substr($query,$pos1);
//	echo $query1;
	$pos1=strpos($query1,"sort");

//	echo "<br><br>";
	$pos2=strpos($query1,")");

	$condition=substr($query1,$pos1,$pos2-$pos1+1);


//	echo $condition;


	if((($pos1+strlen("sort("))-$pos2)!=0) //to check whether sort condition is empty
	{
		

		$conditionAsArray=getArray($condition);

//		print_r($conditionAsArray);

		$records=$records->sort($conditionAsArray);
	}
	else
	{
		$records=$records;
	}
//	echo "<br>";
	/*
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
	*/
	}


	//...........................limit............................................

	if(strpos($query,"limit")!==false)
	{
	$pos1=strpos($query,"limit");
	echo "<br>";
	$query1=substr($query,$pos1);
	echo $query1;
	$pos1=strpos($query1,"(")+1;

	echo "<br><br>";
	$pos2=strpos($query1,")")-1;

	$condition=(int)substr($query1,$pos1,$pos2-$pos1+1);


	echo "condition".$condition;


	$records=$records->limit($condition);

	$totalRecords=$records->count();
	echo $totalRecords;


/*
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
*/
	echo "<br>";

	}





}//end if



$doc_frame=1;



		while ($document = $records->getNext())
	            {

	                $doc = display_json_format($document,0); 
			$format = json_encode($document);	

	?>
                <html>
                    <body> 
                        <fieldset>
                            <legend><?php echo "Document $doc_frame"; ?></legend>
                            <a href="edit_doc.php?id=<?php echo $document['_id'];?>&db=<?php echo $db?>&collection=<?php echo $collection?>&host=<?php echo $host; ?>&port=<?php echo $port; ?>">Edit</a>
                            &nbsp;<a href="remove_doc.php?id=<?php echo $document['_id'];?>&db=<?php echo $db?>&collection=<?php echo $collection?>&host=<?php echo $host; ?>&port=<?php echo $port; ?>" onclick="return confirm('Are you sure, you want to delete document?')">Remove</a><br>
                            <?php echo "$doc"; ?>
                        </fieldset>
                    </body>
                    <br>
                </html>
                
                <?php
                $doc_frame += 1;


			

		    }


?>




<!--Query text box-->
<style>
textarea {
  background-color:black;
color:white;
font-size:15px;
  border: 1px solid #888;
	
}
$('textarea').autoResize(); 
</style>

		<form action=processQuery.php>

		Query: 
                <textarea class="text_query" name="query" style="width:100%; height:75px;">
		<?php printf("\n");?>db.<?php echo $collection;?>.find();
		</textarea>
		<div align=right><input type=submit value=Submit></div>
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>

		</form>



















	
<!--No of records to display-->

    		<div style="display:inline-block;" align=center>

	

		<form action=processQuery.php>
		To display:
		<input type=hidden name=db value="<?php echo $db; ?>"/>
		<input type=hidden name=collection value="<?php echo $collection; ?>"/>
		<input type=hidden name=host value="<?php echo $host; ?>"/>
		<input type=hidden name=port value="<?php echo $port; ?>"/>
		
<!--		<input type=text name=limit value="<?php echo $limit; ?>" onchange="this.form.submit();" /> -->

		<select name=limit onchange="this.form.submit();">

	
		



		<option value=5 <?php if($limit==5) echo "selected=selected"; ?>>5</option>
		<option value=10 <?php if($limit==10) echo "selected=selected"; ?>>10</option>
		<option value=15 <?php if($limit==15) echo "selected=selected"; ?>>15</option>
		<option value=all <?php if($limit==0) echo "selected=selected"; ?>>All</option>

		</select>

		</form>
		</div>
</div></div>
