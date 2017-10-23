<head>
        <link href="css/modal.css" rel="stylesheet" type="text/css" />
</head>
<?php $connection=new Mongo();

	$id=$_GET['id'];
	$db=$_GET['db'];
	$collection=$_GET['collection'];						
	$page=$_GET['page'];

	$dbConnect=$connection->$db;


?>


<!--<a href="#x" class="overlay" id="join_form"></a>-->
<a class="overlay" id="join_form" href="index1.php?collection=<?php echo $collection ?>&db=<?php echo $db ?>&page=<?php echo $page?>#close"></a>

        <div class="popup">
	
		<?php 

			
			$records1=$dbConnect->$collection->findOne(array('_id'=> new MongoId($id)));

			echo "<br><br>";

			echo "localhost"."=>";
			echo $db."=>".$collection." ";
			echo "<br><br>";
		?>
		<center>	
		<table border=2 width=100%" class=idTab>
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
						<td align=center><?php echo $val;?></td>


					</tr>
		<?php
				}
 		?>
		</table>

            <a class="close" href="index1.php?collection=<?php echo $collection ?>&db=<?php echo $db ?>&page=<?php echo $page?>#close"></a>
        </div>
