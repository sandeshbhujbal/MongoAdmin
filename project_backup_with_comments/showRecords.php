<?php

	$id=$_GET[id];
	$db=$_GET[db];
	$collection=$_GET[collection];


	$connection=new Mongo();	
	$db_selection=$connection->$db;

    	$cursor = $db_selection->$collection->find(
        	array(
        	    '_id' => new MongoId($id)
        	)
    	);

	$cursor2array = iterator_to_array($cursor);

	foreach($cursor2array[$id] as $key=>$value)
	{
		echo "$key => $value";
		echo "<br>";

	}
?>
