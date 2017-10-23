<?php

$db=$_GET['db'];
$collection=$_GET['collection'];


$id=new MongoId();


$key=$_GET['newKey'];
$value=$_GET['newValue'];

$connection=new Mongo();
$dbConnect=$connection->$db;

$data=array($key => $value,"_id"=>$id);
print_r($data);
$newdata=array('$set' => $data);

$dbConnect-> $collection->insert($data);


?>
	
	<script>
//		alert("Record Added Successfully."); 
//		window.location = document.referrer;			
		window.location.href = "index1.php?id=<?php echo $id; ?>&db=<?php echo $db;?>&collection=<?php echo $collection;?>#join_form";
	</script>

<!--

<a href="index1.php?id=<?php echo $res[$keys[0]];?>&db=<?php echo $db;?>&collection=<?php echo $collection;?>#join_form" id="join_pop"><?php echo $res[$k];?></a>

window.location.href = "http://new.website.com/that/you/want_to_go_to.html";

-->
