
<?php
		$db=$_GET['db'];
		$collection=$_GET['collection'];

		$connection=new Mongo();
		$db=$connection->$db;


	if($_GET['button']=="Update")
	{


		$records=$db->$collection->find();
		$records->count();


		$records=$db-> $collection ->find();

		$total=$records->count();

		$array = iterator_to_array($records);
//		print_r($array);
		$keys = array();
		foreach ($array as $k=>$v) {
		foreach ($v as $a=>$b) {
			$keys[] = $a;
		}
		}
		$keys = array_values(array_unique($keys));

		//$keys=array_flip(array_reverse(array_flip(array_reverse($keys))));
		//echo "keyss array"."<br>";

//		print_r($keys);
		$data=array();
	
		foreach($keys as $k)
		{	
			if(isset($_GET[$k]))
			{
				if($k!="_id")
				{	
					$data[$k]=$_GET[$k];
				}
				//echo $k."=>";
				//echo $_GET[$k];
				//echo "<br>";
		

			}
		}	

//		print_r($data);
		$newdata=array('$set' => $data);	

		//print_r($newdata);

//		print_r($newdata);
		$db-> $collection->update( array( '_id' => new MongoId($_GET['_id'])), $newdata );
	?>

		<script>
			alert("Updated successfully."); 
			history.go(-1);		
		</script>
		
	<?php
		//echo '<a href="javascript:history.go(-1);">hello</a>';
	}
	elseif($_GET['button']=="delete")
	{
		$criteria = array('_id'=> new MongoId($_GET['_id']));
		$db->$collection->remove($criteria, array("justOne" => true) );

		echo '<script type="text/javascript">'; 
		echo 'alert("Record Deleted Successfully.");'; 
		echo 'window.location.href = "http://localhost/project/project/index1.php?db='.$_GET[db].'&collection='.$_GET[collection].'";';
		echo '</script>';


		
/*		?>
		<script>		
			alert("Record Deleted."); 
			//header("location:http://localhost/project/project/index1.php");
		</script>
		<?php	
			echo "<script>alert('hello')</script>";
			header("location:http://localhost/project/project/index1.php?db=".$_GET['db']."&collection=".$_GET['collection']);

		/*


		<script>
			alert("Record Deleted."); 
			history.go(-1);		
		</script>
		*/


	}	
	?>
