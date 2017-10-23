<?php

$connection=new Mongo();
$dbConnect=$connection->sandesh;
$limit=10;

$records=$dbConnect-> temp ->find()->skip($skip)->limit($limit);

$array = iterator_to_array($records);

?>

<table border=1>




<?php

foreach($array as $pair)
{
	echo count($pair);
	$cnt=1;
		
	echo "<tr>";
	echo "<td>";
		echo "{_id: ".$pair['_id']."}";	
	echo "</td>";
	


	echo "<td>";
	echo "{";

	foreach($pair as $key=>$val)
	{
	if($key!='_id')		
	{	
		if($cnt!=(count($pair)-1))	
		{
			echo $key." : ".$val.", ";
		}
		else
		{
			echo $key." : ".$val;
		}
		$cnt++;
	}
	}
	echo "}</td></tr>";
	
}



?>
</table>
