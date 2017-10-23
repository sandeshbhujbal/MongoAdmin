<?php

$db=$_GET['db'];
$collection=$_GET['collection'];
$id=$_GET['id'];

$key=$_GET['newKey'];
$value=$_GET['newValue'];

$connection=new Mongo();
$dbConnect=$connection->$db;

$data=array($key => $value);
$newdata=array('$set' => $data);

$dbConnect-> $collection->update( array( '_id' => new MongoId($id)), $newdata );


?>
	
	<script>
//		alert("Record Added Successfully."); 
//		window.location = document.referrer;				
		window.location.href = "index1.php?id=<?php echo $id; ?>&db=<?php echo $db;?>&collection=<?php echo $collection;?>#join_form";
	</script>

