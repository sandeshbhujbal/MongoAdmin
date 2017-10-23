<?php



$db=$_GET['db'];
$collection=$_GET['collection'];


$connection=new Mongo();
$dbconnect=$connection->$db;


print_r($_GET['_id']);

$arr=$_GET['_id'];

//echo count($arr);


foreach($arr as $id)
{

$criteria = array('_id'=> new MongoId($id));
$dbconnect->$collection->remove($criteria, array("justOne" => true) );
}
?>
	
	<script>
		alert("Record Deleted."); 
		window.location = document.referrer;				
	</script>

