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
<input type="text" name="newDb" id="newDb" placeholder="Add New Database" style="height:30px; width:65%;"/>
<input type="Submit" value="Add" style="height:35px; width:22%; "/>
&nbsp;
</form>
<br>

<?php

$connection=new Mongo();
$dbList=$connection->admin->command(array("listDatabases"=>1));

?>


<div id='cssmenu'>
<ul>
   <li class='active'><a href='index1.php'><span>Home</span></a></li>
<?php

	
foreach($dbList as $db1)
  {

    foreach($db1 as $db2)
      {
	?>

   <li class='has-sub'><a href='#'><span><?php echo $db2['name'];?></span></a>
      <ul>

	
	  <?php
	  $db=$connection->$db2['name'];
	  $list=$db->listCollections();

	  foreach($list as $collection)
	    {
	?>

		
	
         <li><a href='index1.php?collection=<?php echo $collection->getName();?>&db=<?php echo $db;?>'>
		<span><?php echo $collection->getName();?></span>
		</a></li>

	<?php
	}
	?>
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




<!--<textarea rows="10" cols="100" name="message">Your text...</textarea>
<br>
<input type="submit" value="SEND" name="submit" />
<br>
-->
<?php
if(isset($_GET["collection"]) && isset($_GET["db"]))
	{

		$db=$_GET["db"];		
		$collection=$_GET["collection"];


		echo "<font size=4><b>".$db." -> ".$collection."</b></font>";

		echo "<br>";
		//echo "Database=".$db."<br>";
		//echo "Collection=".$collection."<br>";

		$dbConnect=$connection->$db;
	
		echo "<br>";
		


		/*code for pagenation*/

		$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
		$limit = 10;
		$skip = ($page - 1) * $limit;
		$next = ($page + 1);
		$prev = ($page - 1);

		$totalRecords=$dbConnect-> $collection ->find()->count();
		

		$last=ceil(($totalRecords/$limit));

		$records=$dbConnect-> $collection ->find()->skip($skip)->limit($limit);

		$total=$records->count();

	
		


		$array = iterator_to_array($records);
	
		$keys = array();
		foreach ($array as $k=>$v) {
		foreach ($v as $a=>$b) {
			$keys[] = $a;
		}
		}
		$keys = array_values(array_unique($keys));
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

	<form action="deleteRecords.php" method="get" id="deleteRecords">
	<table border=2 width=100%" class=idTab>

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
				echo '<td align=center><input type="checkbox" id="_id" name="_id[]" value="'.$res[_id].'" onClick="toggleSelectAll(this)"/></td>';

			?>
			<td align=center><?php echo $cnt; $cnt++;?></td>
			
		<?php
			foreach($keys as $k)
			{

		?>
	<!--		<td align=center><a href="JavaScript:newPopup('showRecords.php?id=<?php echo $res[$keys[0]]?>&db=<?php echo $db?>&collection=<?php echo $collection?>');"><?php echo $res[$k]?></a></td>
		-->
			<td align=center>
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
	<br>
	<div id=pageNo align=center>
<?php		
			
	/*Pagenation code displaying previous and next*/

	
	if($page > 1){

	echo ' <a href="?collection='.$collection.'&db='.$db.'&page=1"><font size=5><img src="images/go_first.ico" height=30px title="First"></img> </font></a>';

	echo '<a href="?collection='.$collection.'&db='.$db.'&page=' . $prev . '"><font size=5><img src="images/go_left.ico" height=30px title="Previous"></img></font></a>';
	

	if($page * $limit < $total) {

	echo ' <a href="?collection='.$collection.'&db='.$db.'&page=' . $next . '"><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';
	echo ' <a href="?collection='.$collection.'&db='.$db.'&page=' . $last . '"><font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font></a>';

	}
	else
	{
	
	echo '<font size=5><img src="images/go_right.ico" height=30px></img></font>';
	echo '<font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font>';

	}
	} else {
	

	if($page * $limit < $total) {
		
	echo '<font size=5><img src="images/go_first.ico" height=30px title="First"></img></font>';

	echo '<font size=5><img src="images/go_left.ico" height=30px title="Previous"></img></font>';



	echo ' <a href="?collection='.$collection.'&db='.$db.'&page=' . $next . '"><font size=5><img src="images/go_right.ico" height=30px title="Next"></img></font></a>';
	}
	if($last>1)
		echo ' <a href="?collection='.$collection.'&db='.$db.'&page=' . $last . '"><font size=5><img src="images/go_last.ico" height=30px title="Last"></img></font></a>';
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
	    <li><a href="#" onclick="document.getElementById('deleteRecords').submit();"><span>Delete Selected</span></a></li>
	    <li><a href="index1.php?db=<?php echo $db;?>&collection=<?php echo $collection;?>#insertRecord" id="join_pop"><span>Add New Record</span></a></li>
	  </ul>	
	</div>





	
	<?php 

	}
	else
	{

		echo "hello";

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

	formBody+='<tr><td>Enter Key</td><td>:</td> <td><input type=text name=newKey placeholder="Key"></td></tr>';
	formBody+='<tr><td>Enter Value</td><td>:</td> <td><input type=text name=newValue placeholder="Value"></td></tr>';

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
		
		<form action="update.php" method="get">
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
							<?//php echo $val;


							if($key!="_id")
							{
								echo '<input type=text name='.$key.' value='.$val.' >';
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
			<td><input type=text name=newKey placeholder="Key" id="insert_newKey"></td>
		</tr>

		<tr>
			<td>Enter Value</td>
			<td>:</td>
			<td><input type=text name=newValue placeholder="Value" id="insert_newVal"></td>
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

</body>
</html>
