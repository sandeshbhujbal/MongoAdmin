<?php

$db=$_GET['db'];
$collection=$_GET['collection'];

$key=$_GET['newKey'];
$value=$_GET['newValue'];

$connection=new Mongo();
$dbConnect=$connection->$db;

$data=array($key => $value);
$newdata=array('$set' => $data);

$dbConnect-> $collection->insert($data);


?>
	
	<script>
		alert("Record Added Successfully."); 
		window.location = document.referrer;				
	</script>

